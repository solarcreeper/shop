package com.gwall.test;

/**
 * ������
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
                System.out.println("������������ϣ�"+n+ " " + System.currentTimeMillis());  
                // ����300ms  
                Thread.sleep(300);  
            }  
        } catch (InterruptedException ex) { 
        	
        }  
    }  
}
