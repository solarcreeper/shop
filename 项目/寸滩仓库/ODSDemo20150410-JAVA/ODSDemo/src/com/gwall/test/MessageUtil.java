package com.gwall.test;

import java.util.concurrent.ArrayBlockingQueue;
import java.util.concurrent.BlockingQueue;
import java.util.concurrent.ExecutorService;
import java.util.concurrent.Executors;

/**
 * 生产者消费者
 * @author yk
 *
 */
public class MessageUtil {
	
	/**
	 * 容器
	 */
    public static final BlockingQueue<String> QUEUE = new ArrayBlockingQueue<String>(3);  
      
    /**
     * 生产
     * @param msg
     * @throws InterruptedException
     */
    public static void produce(String msg) throws InterruptedException{  
    	QUEUE.put(msg);
    }
    
    /**
     * 消费
     * @return
     * @throws InterruptedException
     */
    public static String consume() throws InterruptedException{  
        return QUEUE.take();
    }
	
    /**
     * 
     * @param ss
     */
	public static void main(String[] ss){
		ExecutorService service = Executors.newCachedThreadPool();  
        service.submit(new ProducerUtil());
        service.submit(new ConsumerUtil());
        // 程序运行5s后，所有任务停止  
        try {  
            Thread.sleep(5000);  
        } catch (InterruptedException e) {  
        }  
        service.shutdownNow();  
	}
	
	
}
