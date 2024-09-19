import { AMQPClient } from "@cloudamqp/amqp-client";
import {}  from 'dotenv/config';

async function startPublisher() 
{
        try {
                const cloudMQPUUrl = process.env.CLOUDMAP_URL;
                const connection = new AMQPClient(cloudMQPUUrl)
                await connection.connect();
                const channel = await connection.channel();

                console.log("[✅] Connection over channer estabilished");

                //Declare the exchange and queue, and create binding them
                await channel.exchangeDeclare('emails', 'direct');
                const q = await channel.queue('emails.notifications');

                await channel.queueBind('emails.notifications', 'emails', 'notifications');

                async function sendToQueue(routingKey, email, name, body) {
                    const message = {email, name, body};
                    const jsonMessage = JSON.stringify(message);
                    //amqp-client function expects: publish(exchange, routing, message, options) 
                    await q.publish('emails',  {routingKey}, jsonMessage);
                    console.log("[📥] Message sent to queue", message)
                }

                //Send some messages to the queue
                sendToQueue("notification", "example@example.com", "John Doe", "You order has received");
                sendToQueue("notification", "example@example.com", "John Doe", "The product is back in stock");
                sendToQueue("resetPassword", "example@example.com", "Willen da Foe", "Here is your new password");

                setTimeout(function() { 
                        connection.close();
                        console.log("[❎] Connection closed");
                        process.exit(0);
                }, 500);

        } catch (error) {
                console.lerror(error);
                //Retry after 3 seconds
                setTimeout(function() {
                        startPublisher();
                }, 3000);
        }
}

startPublisher();