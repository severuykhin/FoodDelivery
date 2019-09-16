import csv
import httplib2
import apiclient.discovery
from oauth2client.service_account import ServiceAccountCredentials

# Define variables
API_CREDENTIALS = "key.json"
conversions_csv_path = "metrics.csv"
impressions_csv_path = "master.csv"
report_csv_path = "report.csv"

conversions = []


# Preparing Google API
credentials = ServiceAccountCredentials.from_json_keyfile_name(API_CREDENTIALS, [ 'https://www.googleapis.com/auth/spreadsheets',
                                                                                  'https://www.googleapis.com/auth/drive' ])

httpAuth = credentials.authorize(httplib2.Http())
service = apiclient.discovery.build('sheets', 'v4', http = httpAuth)

  
def csv_to_array(file_obj):
    reader = csv.reader(file_obj)
    for idx, row in enumerate(reader):
        if (idx == 0 or idx == 1): continue
        data = { 
            "phrase": row[2], 
            "ssystem": row[1],
            "count": row[4] 
        }
        conversions.append(data)

def write_impressions_row(data):
    with open(report_csv_path, "a") as report_file_obj:
        report_writer = csv.writer(report_file_obj, delimiter=',', quotechar='"', quoting=csv.QUOTE_MINIMAL)
        report_writer.writerow([
            data["phrase"], 
            data["impressions"], 
            data["clicks"], 
            data["ctr"], 
            data["conversions"],
            data["conversions_impressions"],
            data["conversions_clicks"]])

def read_impressions(file_obj):
    reader = csv.reader(file_obj)

    # Append table header
    write_impressions_row({ 
        "phrase":"Поисковый запрос", 
        "impressions":"Показы", 
        "clicks":"Клики", 
        "ctr":"CTR", 
        "conversions":"Достижения цели",
        "conversions_impressions":"Конверсия показа в заказ",
        "conversions_clicks":"Конверсия клика в заказ" })

    # Iterate over each impressions row
    for idx, row in enumerate(reader):

        if (idx == 0): continue

        phrase = row[0]

        data = {
            "phrase": phrase,
            "impressions": row[2],
            "clicks": row[3],
            "ctr": row[4],
            "conversions": 0,
            "conversions_impressions": 0,
            "conversions_clicks": 0
        }

        conversionsArr = list(filter(lambda  item: (item["phrase"] == phrase), conversions))

        # Add conversions data to impressions row
        for item in conversionsArr:
            data["conversions"] = data["conversions"] + int(item["count"])

        impressions = float(data["impressions"])
        clicks = float(data["clicks"])

        if (impressions > 0):
            data["conversions_impressions"] = data["conversions"] / (impressions / 100)
        if (clicks > 0):    
            data["conversions_clicks"] = data["conversions"] / (clicks / 100)

        write_impressions_row(data) 



if __name__ == "__main__":

    report = open(report_csv_path, "w")
    report.truncate()
    report.close()

    with open(conversions_csv_path) as conversions_file_obj:
        csv_to_array(conversions_file_obj)

    with open(impressions_csv_path) as impressions_file_obj:
        read_impressions(impressions_file_obj)