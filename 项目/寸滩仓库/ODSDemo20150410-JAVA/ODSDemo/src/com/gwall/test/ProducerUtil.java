package com.gwall.test;

/**
 * 生产者
 * @author yk
 *
 */
public class ProducerUtil implements Runnable {  
	
    public void run() {  
        try {  
        	int n = 0;
            while (true) {
            	n++;
                MessageUtil.produce(n+"");  
                System.out.println("生产者生产完毕："+n+ " " + System.currentTimeMillis());  
                // 休眠300ms  
                Thread.sleep(300);  
            }  
        } catch (InterruptedException ex) { 
        	
        }  
    }  
}
