package textprocessing;
import java.util.LinkedList;
import java.util.Queue;
public class FileContents {
    private Queue<String> queue;
    private int registerCount = 0;
    private boolean closed = false;
    private int maxFiles, maxChars;

    public FileContents(int maxFiles, int maxChars) {
        queue = new LinkedList<>();
        this.maxFiles = maxFiles;
        this.maxChars = maxChars;
    }

    public void registerWriter() {
        registerCount++;
        closed = true;
    }

    public void unregisterWriter() {
        registerCount--;
        closed = registerCount != 0;
    }

    public void addContents(String contents) {
        if(!closed) return;
        if(canAdd(contents)) queue.add(contents);
    }

    private boolean canAdd(String contents) {
        boolean canAdd = true;

        if(queue.size() >= maxFiles) canAdd = false;
        if(contents.length() > maxChars) canAdd = false;

        return canAdd;
    }

    public String getContents() {
        if(closed) return null;

        String fileContent = queue.poll();
        if(fileContent != null) return fileContent;
        else{
            try {
                wait();
            } catch (InterruptedException e) {
                e.printStackTrace();
            }
            return queue.poll();
        }
    }
}
