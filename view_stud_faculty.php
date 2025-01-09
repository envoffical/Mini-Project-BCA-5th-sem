<!-- Include the modal structure -->
<div class="modal fade" id="viewStudentsModal" tabindex="-1" aria-labelledby="viewStudentsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewStudentsModalLabel">Students List</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Scrollable student list -->
                <div class="student-list" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Semester</th>
                            </tr>
                        </thead>
                        <tbody id="studentData">
                            <!-- Student data will be dynamically inserted here -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
function viewStudents(semester) {
    // Perform an AJAX request to fetch students for the selected semester
    $.ajax({
        url: 'fetch_stud_fac.php', // Create this PHP file to handle fetching student data
        type: 'GET',
        data: { semester: semester },
        success: function(data) {
            $('#studentData').html(data); // Insert the fetched data into the modal's body
            $('#viewStudentsModal').modal('show'); // Show the modal
        },
        error: function() {
            alert('Failed to fetch student data.');
        }
    });
}
</script>