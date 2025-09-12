function showAddRoomForm() {
            document.getElementById('formTitle').innerText = 'Thêm phòng';
            document.getElementById('roomForm').style.display = 'block';
            document.getElementById('formRoom').reset();
            document.getElementById('roomId').value = '';
        }
        function showEditRoomForm(id) {
            document.getElementById('formTitle').innerText = 'Sửa phòng #' + id;
            document.getElementById('roomForm').style.display = 'block';
            // TODO: Load dữ liệu phòng theo id để sửa (hiện tại là mẫu tĩnh)
        }
        function hideRoomForm() {
            document.getElementById('roomForm').style.display = 'none';
        }
        function deleteRoom(id) {
            if (confirm('Bạn có chắc muốn xóa phòng #' + id + '?')) {
                // TODO: Xử lý xóa phòng ở backend
            }
        }
        function saveRoom(event) {
            event.preventDefault();
            // TODO: Xử lý lưu phòng (thêm/sửa) ở backend
            hideRoomForm();
        }