package textprocessing;

import java.util.LinkedList;
import java.util.Queue;

class FileContents {
    private Queue<String> queue;
    private int registerCount = 0;
    private boolean closed = false;
    private int actualChars = 0;
    private int maxFiles, maxChars;

    FileContents(int maxFiles, int maxChars) {
        queue = new LinkedList<>();
        this.maxFiles = maxFiles;
        this.maxChars = maxChars;
    }

    synchronized void registerWriter() {
        registerCount++;
    }

    synchronized void unregisterWriter() {
        registerCount--;
        if (registerCount == 0) closed = true;
    }

    synchronized void addContents(String contents) {
        boolean canAdd = canAdd(contents);

        while (!canAdd) {
            try {
                wait();
            } catch (InterruptedException e) {
                e.printStackTrace();
            }
            canAdd = canAdd(contents);
        }

        queue.add(contents);
        actualChars += contents.length();
        notifyAll();
    }

    private synchronized boolean canAdd(String contents) {
        if (queue.isEmpty()) return true;
        if (queue.size() >= maxFiles) return false;
        if (actualChars + contents.length() > maxChars) return false;

        return true;
    }

    synchronized String getContents() {
        String fileContent = queue.poll();
        if (fileContent != null) {
            actualChars -= fileContent.length();
            notifyAll();
            return fileContent;
        } else {
            if (closed) return null;
            try {
                wait();
            } catch (InterruptedException e) {
                e.printStackTrace();
            }
            return getContents();
        }
    }
}
