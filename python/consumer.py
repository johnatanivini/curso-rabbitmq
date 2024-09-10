from dotenv import load_dotenv
import pika, os

load_dotenv()

url = os.environ.get('CLOUDMAP_URL')
params = pika.URLParameters(url)
connection = pika.BlockingConnection(params)
channel = connection.channel() #start a channel
channel.queue_declare(queue='test_queue')

def callback(ch, method, properties, body):
    print ('[x] Receive ' + str(body))

channel.basic_consume(
    'test_queue',
    callback,
    auto_ack=True
)

print ('[x] Waiting for messages:')

channel.start_consuming()
channel.close()


