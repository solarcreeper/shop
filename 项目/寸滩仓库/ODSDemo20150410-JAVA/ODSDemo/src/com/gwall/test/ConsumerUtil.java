package com.gwall.test;

/**
 * ������
 * @author yk
 *
 */
public class ConsumerUtil implements Runnable {
	
    public void run() {  
        try {  
            while (true) {  
                System.out.println("������������ϣ�" +MessageUtil.consume()+" " + System.currentTimeMillis());  
                // ����1000ms  
                Thread.sleep(200);  
            }  
        } catch (InterruptedException ex) {  
        }  
    }  

}
