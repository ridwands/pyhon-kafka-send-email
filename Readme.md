# pyhon-kafka-send-email

![alt text](https://github.com/ridwands/pyhon-kafka-send-email/blob/master/preview.png?raw=true)

## Import Database
```
import book_store.sql to Your MySQL Database
```
## Change Kafka Broker And Topic on Publisher
publisher/main.py
```
p = Producer({
    'bootstrap.servers' : 'Your Kafka Server'
    })

p.produce('Your Topic Kafka', value=data)
```

## Change Kafka Broker And Topic on Consumer
consumer/main.py
```
conf = {'bootstrap.servers': "YOUR KAFKA SERVER",
        'group.id' : 'YOUR KAFKA TOPIC',
        'auto.offset.reset': 'smallest'}

c = Consumer(conf)

c.subscribe(['YOUR KAFKA TOPIC'])
 ```
## PUT YOUR API SENDGRID AND FROM EMAIL
consumer/main.py
```
sg = sendgrid.SendGridAPIClient(api_key='YOUR API KEY SENDGRID')
    
from_email = Email("EMAIL FROM")
 ```

## Install Dependencies
```
pip install -r publisher/requirements.txt
pip install -r consumer/requirements.txt
cd book-store && composer install
```
## Running Application
```
Running book-store on apache/nginx or php artisan serve
Running Publisher python main.py
Running Consumer python main.py
```

