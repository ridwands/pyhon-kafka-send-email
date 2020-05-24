from confluent_kafka import Consumer
import sendgrid
from sendgrid.helpers.mail import *
import json
from rupiah_format import transform_to_rupiah_format

conf = {'bootstrap.servers': "YOUR KAFKA SERVER",
        'group.id' : 'YOUR KAFKA TOPIC',
        'auto.offset.reset': 'smallest'}

c = Consumer(conf)

c.subscribe(['YOUR KAFKA TOPIC'])

while True:
    msg = c.poll(1.0)

    if msg is None:
        continue
    if msg.error():
        print("Consumer error: {}".format(msg.error()))
        continue

    data = json.loads(msg.value())
    sg = sendgrid.SendGridAPIClient(api_key='YOUR API KEY SENDGRID')
    
    from_email = Email("EMAIL FROM")
    to_email = To(data['email'])
    subject = "Payment Detail"
    content = Content("text/plain", "This is Detail Your Payment\nEmail: " +str(data['email'])+"\nBook Name: "+str(data['payment']['book_name'])+"\nPrice: "+str(transform_to_rupiah_format(data['payment']['price']))+"\nAmount: "+str(data['payment']['amount'])+"\nTotal: "+str(transform_to_rupiah_format(data['payment']['total'])))
    mail = Mail(from_email, to_email, subject, content)
    response = sg.client.mail.send.post(request_body=mail.get())
    print(response.status_code)
    print(response.body)
    print(response.headers)
c.close()