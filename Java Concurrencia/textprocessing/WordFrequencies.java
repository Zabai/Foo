package textprocessing;

import java.util.Map;
import java.util.HashMap;

class WordFrequencies {
    private Map<String, Integer> wordsMap;

    WordFrequencies() {
        wordsMap = new HashMap<>();
    }

    synchronized void addFrequencies(Map<String, Integer> f) {
        for (String key : f.keySet()) {
            wordsMap.put(key,
                    wordsMap.containsKey(key) ? wordsMap.get(key) + f.get(key) : f.get(key));
        }
    }

    synchronized Map<String, Integer> getFrequencies() {
        return wordsMap;
    }
}
