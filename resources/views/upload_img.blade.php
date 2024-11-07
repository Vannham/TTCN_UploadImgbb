@extends("layout")

@section("content")
    <style>
        .home_cover {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: flex-start; /* Đẩy nội dung lên phía trên */
            align-items: center;
            padding-top: 15%; /* Điều chỉnh khoảng cách từ trên xuống */
        }

        h1 {
            font-size: 3rem;
            color: #333;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.25);
        }

        h5 {
            font-size: 22px;
            font-weight: 100;
            margin: 20px 0;
            color: #424040;
            text-align: center;
            width: 790px; /* Điều chỉnh chiều rộng */
        }

        .home_buttons a {
            padding: 12px 30px;
            background-color: rgb(2, 132, 199);
            border-radius: 2px;
            color: white; /* Màu chữ cho nút */
            text-transform: uppercase; /* Chữ in hoa */
            transition: background-color 0.3s; /* Hiệu ứng chuyển màu khi hover */
        }

        .home_buttons a:hover {
            background-color: rgb(2, 105, 170); /* Màu nền khi hover */
        }

        #responseMessage {
            margin-top: 20px; /* Khoảng cách giữa nút và thông báo */
        }
    </style>

    <main class="flex flex-col items-center justify-center min-h-screen">
        <div class="home_cover mx-auto z-20">
            <h1 class="font-bold text-center title">Đăng và chia sẻ những bức ảnh của bạn</h1>
            <h5 class="text-center text-2xl center-box color-[#333333] content">
            Drag and drop anywhere you want and start uploading your images now. 32 MB limit. Direct image links, BBCode and HTML thumbnails.
            </h5>
            <div class="home_buttons flex justify-center pt-2">
                <input type="file" id="fileInput" class="hidden" accept="image/*" multiple>
                <a href="#" id="startUpload" class="text-white uppercase bg-sky-600 mx-auto start_upload">BẮT ĐẦU TẢI LÊN</a>
            </div>
        </div>
    </main>

    <div id="responseMessage"></div> <!-- Thêm div này để hiển thị thông báo phản hồi -->

    <script>
        const startUpload = document.getElementById('startUpload');
        const fileInput = document.getElementById('fileInput');
        const responseMessage = document.getElementById('responseMessage');

        // Mở hộp thoại chọn tệp khi nhấn nút
        startUpload.addEventListener('click', (event) => {
            event.preventDefault(); // Ngăn chặn hành vi mặc định của liên kết
            fileInput.click();
            document.getElementById("fileInput").addEventListener("change",()=>{
                document.getElementById('uploadModal').classList.remove('hidden');
            document.getElementById('modalOverlay').classList.remove('hidden');
            })

        });

        // Xử lý khi người dùng chọn tệp
        fileInput.addEventListener('change', (event) => {
            const files = event.target.files;
            if (files.length > 0) {
                uploadFiles(files);
            }
        });

        function uploadFiles(files) {
            const formData = new FormData();
            for (let i = 0; i < files.length; i++) {
                formData.append('files[]', files[i]);
            }

            fetch("{{ route('upload') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    responseMessage.innerHTML = `<p class="text-green-500">Tải lên thành công!</p>`;
                } else {
                    responseMessage.innerHTML = `<p class="text-red-500">Đã có lỗi xảy ra! Vui lòng thử lại.</p>`;
                }
            })
            .catch(error => {
                responseMessage.innerHTML = `<p class="text-red-500">Đã có lỗi xảy ra! Vui lòng thử lại.</p>`;
            });
        }
    </script>
@endsection
