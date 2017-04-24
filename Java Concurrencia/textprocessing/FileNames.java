package textprocessing;
import java.util.LinkedList;
import java.util.Queue;
public class FileNames {
    private Queue<String> queue;
    private boolean blocked;

    public FileNames() {
        queue = new LinkedList<>();
        blocked = false;
    }

    public void addName(String fileName) {
        if(!blocked) queue.add(fileName);
    }
    public String getName() {
        if(blocked) return null;

        String fileName = queue.poll();
        if(fileName != null) return fileName;
        else{
            try {
                wait();
            } catch (InterruptedException e) {
                e.printStackTrace();
            }
            return queue.poll();
        }
    }

    public void noMoreNames() {
        blocked = true;
    }
}