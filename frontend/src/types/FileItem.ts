export class FileItem {
    public id: number;
    public title: string;
    public size: number;
    public extension: string;
    public previewPath: string;
    public path: string;
    constructor(json: File) {
        this.id = json.id;
        this.title = json.title;
        this.size = json.size;
        this.extension = json.extension;
        this.previewPath = json.previewPath;
        this.path = json.path;
    }
}

type File = {
    id: number;
    title: string;
    size: number;
    extension: string;
    previewPath: string;
    path: string;
}
