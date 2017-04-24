package textprocessing;

class FileReader extends Thread {
    private FileNames fileNames;
    private FileContents fileContents;

    FileReader(FileNames fn, FileContents fc) {
        fileNames = fn;
        fileContents = fc;
    }

    @Override
    public void run() {
        String fileName = fileNames.getName();

        fileContents.registerWriter();

        while (fileName != null) {
            String fileContent = Tools.getContents(fileName);
            fileContents.addContents(fileContent);
            fileName = fileNames.getName();
        }

        fileContents.unregisterWriter();
    }
}
