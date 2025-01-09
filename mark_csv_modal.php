<div class="modal fade" id="bulkUploadModal" tabindex="-1" aria-labelledby="bulkUploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bulkUploadModalLabel">Bulk Upload Marks</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="upload_markfile.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="fileInput" class="form-label">Choose CSV file</label>
                            <input class="form-control" type="file" id="fileInput" name="fileToUpload" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="upload">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
