from flask import Flask, request, jsonify
from confluent_kafka import Producer
import json

app = Flask (__name__)

@app.route('/payment', methods=['POST'])
def payment():
    book_name=request.json['book_name']
    price=float(request.json['price'])
    amount=int(request.json['amount'])
    email=request.json['email']
    data = {
        "email" : email,
        "payment" : {
            "book_name" : book_name,
            "price" : price,
            "amount" : amount,
            "total" : (price*amount)
        }
    }
    data = json.dumps(data)
    print (data)
    p = Producer({
    'bootstrap.servers' : 'Your Kafka Server'
    })

    p.produce('Your Topic Kafka', value=data)

    p.flush()
    return jsonify({
        "message" : "message successfully send to kafka"
    })

if __name__=="__main__":
    app.run(host='0.0.0.0', port=5001)