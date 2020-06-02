<?php

namespace common\services\elastic;

use common\dto\Order;
use common\dto\OrderItem;
use Elasticsearch\ClientBuilder;

class ElasticOrderItem
{

    const INDEX_NAME = 'order-item';

    const HOSTS = [
        '92.53.104.20:9200'
    ];

    private $orderItem;
    private $order;
    
    private $client;

    public function __construct(OrderItem $orderItem, Order $order)
    {
        $this->orderItem = $orderItem;
        $this->order = $order;

        $this->client = ClientBuilder::create()->setHosts(self::HOSTS)->build();
    }

    public function save()
    {
        $current_date = date('Y.m.d');

        $index_is_exists = $this->checkIndexExists();

        if (false === $index_is_exists) {
            $index_mapping = $this->getIndexMapping();
            $index_is_exists = $this->createIndex($index_mapping);
        }

        if ($index_is_exists) {
            $document = [
                'index' => self::INDEX_NAME,
                    'type' => '_doc',
                    'body' => [
                        "tags" => ['order'],
                        "@timestamp" => $this->getTimestamp($this->order->date),
                        "full_id" => $this->orderItem->full_id,
                        "product_id" => $this->orderItem->site_id,
                        "product_ids" => [$this->orderItem->site_id],
                        "order_id" => $this->orderItem->order_id,
                        "title" => $this->orderItem->title,
                        "price" => $this->orderItem->price,
                        "cost" => $this->orderItem->getCost(),
                        "quantity" => $this->orderItem->quantity,
                        "categories" => [$this->orderItem->category_id],
                        "name" => $this->order->name,
                        "phone" => $this->order->phone,
                        "street" => $this->order->street,
                        "house" => $this->order->house,
                        "full_address" => $this->order->getFullAddress(),
                        "gender" => $this->order->gender
                    ]
            ];

            $index_response = $this->client->index($document);

            return $index_response['result'];
        }
        
    }

    /**
     * Проверяте существование индекса в ElasticSearch
     */
    private function checkIndexExists(): bool
    {   
        return $this->client->indices()->exists([
            'index' => self::INDEX_NAME
        ]);
    }

    private function getTimestamp($t)
    {
        $micro = sprintf("%06d",($t - floor($t)) * 1000000);
        $d = new \DateTime(date('Y-m-d H:i:s.'.$micro, $t));
        $d->setTimezone(new \DateTimeZone("UTC"));
        $timestamp = $d->format("Y-m-d H:i:s.u");

        return $timestamp;
    }

    private function getIndexMapping(): array
    {
        return [
            'index' => self::INDEX_NAME,
            'body' => [
                'settings' => [
                    'number_of_shards' => 1,
                    'number_of_replicas' => 1
                ],
                'mappings' => [
                    "dynamic_templates" => [
                        [
                            "message_field" => [
                                "path_match" => "message",
                                "match_mapping_type" => "string",
                                "mapping" => [
                                    "norms" => false,
                                    "type" => "text"
                                ]
                            ]
                        ],
                        [
                            "string_fields" => [
                                "match" => "*",
                                "match_mapping_type" => "string",
                                "mapping" => [
                                    "fields" => [
                                        "keyword" => [
                                            "ignore_above" => 256,
                                            "type" => "keyword"
                                        ]
                                    ],
                                    "norms" => false,
                                    "type" => "text"
                                ]
                            ]
                        ]
                    ],
                    'properties' => [
                        "@timestamp" => [
                            "type" => "date",
                            "format" => "yyyy-MM-dd HH:mm:ss.SSSSSS"
                        ],
                        "tags" => [
                            "type" => "text",
                            "norms" => false,
                            "fields" => [
                                "keyword" => [
                                    "type" => "keyword",
                                    "ignore_above" => 256
                                ]
                            ]
                        ],
                        "categories" => [
                            "type" => "text",
                            "norms" => false,
                            "fields" => [
                                "keyword" => [
                                    "type" => "keyword",
                                    "ignore_above" => 256
                                ]
                            ]
                        ],
                        "full_id" => [
                            "type" => "text",
                            "norms" => false
                        ],
                        "product_ids" => [
                            "type" => "text",
                            "norms" => false,
                            "fields" => [
                                "keyword" => [
                                    "type" => "keyword",
                                    "ignore_above" => 256
                                ]
                            ]
                        ],
                        "product_id" => [
                            "type" => "text",
                            "norms" => false
                        ],
                        "order_id" => [
                            "type" => "text",
                            "norms" => false
                        ],
                        "title" => [
                            "type" => "text",
                            "norms" => false
                        ],
                        "price" => [
                            "type" => "short"
                        ],
                        "cost" => [
                            "type" => "short"
                        ],
                        "quantity" => [
                            "type" => "byte"
                        ],
                        "name" => [
                            "type" => "text"
                        ],
                        "phone" => [
                            "type" => "text"
                        ],
                        "street" => [
                            "type" => "text"
                        ],
                        "house" => [
                            "type" => "text"
                        ],
                        "gender" => [
                            "type" => "text"
                        ],
                        "full_address" => [
                            "type" => "text"
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * Создает индекс в ElasticSearch с соответствующим mapping
     */
    private function createIndex(array $index_mapping): bool
    {
        $response = $this->client->indices()->create($index_mapping);
        return isset($response['acknowledged']) ? isset($response['acknowledged']) : false;
    }

}