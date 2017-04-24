package textprocessing;

import java.util.LinkedList;
import java.util.Queue;

class FileNames {
    private Queue<String> queue;
    private boolean blocked = false;

    FileNames() {
        queue = new LinkedList<>();
    }

    synchronized void addName(String fileName) {
        if (blocked) return;
        queue.add(fileName);
        System.out.println("+" + fileName);
        notifyAll();
    }

    synchronized String getName() {
        String fileName = queue.poll();
        if (fileName != null) {
            System.out.println("-" + fileName);
            return fileName;
        }
        else{
            if (blocked) return null;
            try {
                wait();
            } catch (InterruptedException e) {
                e.printStackTrace();
            }
            return getName();
        }
    }

    synchronized void noMoreNames() {
        System.out.println("--- No More Names ---");
        blocked = true;
    }
}