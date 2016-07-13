package com.gwall.test;

/**
 * 消费者
 * @author yk
 *
 */
public class ConsumerUtil implements Runnable {
	
    public void run() {  
        try {  
            while (true) {  
                System.out.println("消费者消费完毕：" +MessageUtil.consume()+" " + System.currentTimeMillis());  
                // 休眠1000ms  
                Thread.sleep(200);  
            }  
        } catch (InterruptedException ex) {  
        }  
    }  

}
