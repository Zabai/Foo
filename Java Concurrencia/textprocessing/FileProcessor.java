package textprocessing;

import java.util.HashMap;
import java.util.Map;

class FileProcessor extends Thread {
    private FileContents fileContents;
    private WordFrequencies wordFrequencies;

    FileProcessor(FileContents fc, WordFrequencies wf) {
        fileContents = fc;
        wordFrequencies = wf;
    }

    @Override
    public void run() {
        String fileContent = fileContents.getContents();

        String regex = "[^\\wÁ-ú]+";

        while (fileContent != null) {
            Map<String, Integer> wordsMap = new HashMap<>();

            for (String word :
                    fileContent.split(regex)) {
                wordsMap.put(word,
                        wordsMap.containsKey(word) ? wordsMap.get(word) + 1 : 1);
            }

            wordFrequencies.addFrequencies(wordsMap);

            fileContent = fileContents.getContents();
        }
    }
}
