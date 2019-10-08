import csv
from DATA_MAP import createMap

MAP = createMap()

# Define variables
SOURCE_CSV = "webmaster-summary.csv"
TARGET_CSV = "queries-reports.csv"
CONVERSIONS_CSV = "conversions.csv"

CONVERSIONS = []


def csv_to_array(file_obj):
    reader = csv.reader(file_obj)
    for idx, row in enumerate(reader):
        if (idx == 0 or idx == 1): continue
        data = { 
            "query": row[0], 
            "count": row[2] 
        }
        CONVERSIONS.append(data)

def write_row(data):
    with open(TARGET_CSV, "a") as report_file_obj:
        report_writer = csv.writer(report_file_obj, delimiter=',', quotechar='"', quoting=csv.QUOTE_MINIMAL)
        report_writer.writerow([
            data["phrase"], 
            data["impressions"], 
            data["clicks"], 
            data["ctr"],
            data["conversions"]
        ])

def read_queries(file_obj):
    reader = csv.reader(file_obj)

    for idx, row in enumerate(reader):

        if (idx == 0): continue

        query = row[0]

        # Содержт ли запрос минус слова
        skip_query = False 
        for word in MAP["negative_words"]:
            if word in query:
                skip_query = True 
                continue 

        if skip_query: continue
        
        for group in MAP["query_groups"]:
            for search_key in group["search_keys"]:
                if search_key in query:

                    mismatch = False
                    
                    # Ищем возможные пересекающиеся значения по ключам Прим: ед -> обед
                    if (len(group["group_negative_keys"]) > 0):
                        for neg_key in group["group_negative_keys"]:
                            if neg_key in query:
                                mismatch = True

                    if mismatch == True: continue

                    group["impressions"] += int(float(row[2]))
                    group["clicks"] += int(float(row[3]))

                    conversionsArr = list(filter(lambda  item: (item["query"] == query), CONVERSIONS))

                    queryConversionsCount = 0

                    # Add conversions data to impressions row
                    for item in conversionsArr:
                        queryConversionsCount = queryConversionsCount + int(item["count"])
                        group['conversions'] = group['conversions'] + int(item["count"])

                    row.append(queryConversionsCount)
                    group["queries_data"].append(row)

def process_queries():

    MAP['query_groups'].sort(key=lambda group: group['impressions'], reverse=True)

    for group in MAP['query_groups']:
        group["queries_data"].sort(key=lambda x: x[1])

def build_report():

    write_row({
        "phrase": "Группа",
        "impressions": "Показы",
        "clicks": "Клики",
        "ctr": "CTR",
        "conversions": "Конверсии"
    })

    for group in MAP['query_groups']:
        
        group_summary_info = {
            "phrase": group["name"],
            "impressions": group["impressions"],
            "clicks": group["clicks"],
            "ctr": '',
            "conversions": group["conversions"]
        }

        write_row(group_summary_info)

        for row in group["queries_data"]:            
            data = {
                "phrase": row[0],
                "impressions": row[2],
                "clicks": row[3],
                "ctr": row[4],
                "conversions": row[25]
            }
            write_row(data)



if __name__ == "__main__":

    report = open(TARGET_CSV, "w")
    report.truncate()
    report.close()

    with open(CONVERSIONS_CSV) as conversions_file_obj:
        csv_to_array(conversions_file_obj)

    with open(SOURCE_CSV) as queries_file_obj:
        read_queries(queries_file_obj)
        process_queries()
        build_report()