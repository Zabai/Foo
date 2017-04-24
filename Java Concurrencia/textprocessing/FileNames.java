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
        return "";
    }

    public void noMoreNames() {
        blocked = true;
    }
}