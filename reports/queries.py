import csv

# Define variables
SOURCE_CSV = "webmaster-summary.csv"
TARGET_CSV = "queries-reports.csv"

MAP = {
    "query_groups": [
        {
            "name": "еда",
            "group_negative_keys": ["обед"],
            "search_keys": ["ед"],
            "queries_data": [],
            "impressions": 0,
            "clicks": 0
        },
        {
            "name": "Пельмени",
            "group_negative_keys": [],
            "search_keys": ["пельмен"],
            "queries_data": [],
            "impressions": 0,
            "clicks": 0
        },
        {
            "name": "Пицца",
            "group_negative_keys": [],
            "search_keys": ["пицц"],
            "queries_data": [],
            "impressions": 0,
            "clicks": 0
        },
        {
            "name": "Роллы",
            "group_negative_keys": [],
            "search_keys": ["ролл"],
            "queries_data": [],
            "impressions": 0,
            "clicks": 0
        },
        {
            "name": "Обеды",
            "group_negative_keys": [],
            "search_keys": ["обед"],
            "queries_data": [],
            "impressions": 0,
            "clicks": 0
        },
        {
            "name": "Ужин",
            "group_negative_keys": [],
            "search_keys": ["ужин"],
            "queries_data": [],
            "impressions": 0,
            "clicks": 0
        },
        {
            "name": "Чебурек",
            "group_negative_keys": [],
            "search_keys": ["чебур"],
            "queries_data": [],
            "impressions": 0,
            "clicks": 0
        },
        {
            "name": "Суп",
            "group_negative_keys": [],
            "search_keys": ["суп"],
            "queries_data": [],
            "impressions": 0,
            "clicks": 0
        },
        {
            "name": "Салат",
            "group_negative_keys": [],
            "search_keys": ["салат"],
            "queries_data": [],
            "impressions": 0,
            "clicks": 0
        },
        {
            "name": "Удон",
            "group_negative_keys": [],
            "search_keys": ["удон"],
            "queries_data": [],
            "impressions": 0,
            "clicks": 0
        },
        {
            "name": "Домашняя еда",
            "group_negative_keys": [],
            "search_keys": ["домашн", "ед"],
            "queries_data": [],
            "impressions": 0,
            "clicks": 0
        },
        {
            "name": "Лапша",
            "group_negative_keys": [],
            "search_keys": ["лапш", "удон", "вок"],
            "queries_data": [],
            "impressions": 0,
            "clicks": 0
        },
    ],
    "negative_words": ["йола"]
}

def write_row(data):
    with open(TARGET_CSV, "a") as report_file_obj:
        report_writer = csv.writer(report_file_obj, delimiter=',', quotechar='"', quoting=csv.QUOTE_MINIMAL)
        report_writer.writerow([
            data["phrase"], 
            data["impressions"], 
            data["clicks"], 
            data["ctr"]
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

                    if mismatch == False:        
                        group["queries_data"].append(row)
                        group["impressions"] += int(float(row[2]))
                        group["clicks"] += int(float(row[3]))

def process_queries():
    for group in MAP['query_groups']:
        group["queries_data"].sort(key = lambda x: x[1])

def build_report():

    write_row({
        "phrase": "Группа",
        "impressions": "Показы",
        "clicks": "Клики",
        "ctr": "CTR"
    })

    for group in MAP['query_groups']:
        
        group_summary_info = {
            "phrase": group["name"],
            "impressions": group["impressions"],
            "clicks": group["clicks"],
            "ctr": ''
        }

        write_row(group_summary_info)

        for row in group["queries_data"]:            
            data = {
                "phrase": row[0],
                "impressions": row[2],
                "clicks": row[3],
                "ctr": row[4],
            }
            write_row(data)



if __name__ == "__main__":

    report = open(TARGET_CSV, "w")
    report.truncate()
    report.close()

    with open(SOURCE_CSV) as queries_file_obj:
        read_queries(queries_file_obj)
        process_queries()
        build_report()