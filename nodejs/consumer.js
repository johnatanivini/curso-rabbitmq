import { AMQPClient } from "@cloudamqp/amqp-client";
import {} from 'dotenv/config';

async function startConsumer() {
     const cloudAQPURL = process.env.CLOUDMAP_URL;
     const connection = new AMQPClient(cloudAQPURL);
     await connection.connect();
     const channel = await connection.channel();

    console.log("[✅] Connection over channel established");
    const q = await channel.queue("email.notifications");

    let counter = 0;

    const consumer = await q.subscribe({noAck: false}, async (msg) => {
        try {
            console.log(`[📤] Message received (${++counter})`, msg.bodyToString());
            msg.ack();
        } catch(error) {
            console.log(error);
        }
    })

    process.on('SIGINT', () => {
        channel.close();
        connection.close();
        console.log('[❎] Connection closed');
        process.exit(0);
    })

}

startConsumer().catch(console.error);