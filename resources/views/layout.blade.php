<!DOCTYPE html>
<html lang="en" id="upload">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ImgBB — Máy chủ tải ảnh miễn phí / Tải ảnh</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/light.min.css">


    <style>
        .show_language {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            grid-template-rows: repeat(7, auto);
            gap: 10px;
            padding: 10px;
            border-top: 1px solid #ccc;
            margin-left: 5px;
        }
        .language {
            margin-left: 10px;
        }
        .image-preview {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            margin-top: 5px;
        }
        #modalOpenBtn {
    position: relative;
}

#modalOpenBtn:after {
    content: "";
    position: absolute;
    bottom: -2px; /* Độ dày của đường gạch ngang */
    left: 0;
    width: 0;
    height: 2px; /* Chiều cao của đường gạch ngang */
    background-color: #00bcd4; /* Màu xanh của đường gạch ngang */
    transition: width 0.3s ease;
}




.underline-on-click::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 2px;
    background-color: #2879B0; /* Màu xanh bạn mong muốn */
    transition: width 0.3s;
}


    </style>
</head>
<body class="bg-white text-gray-800">

<header class="sticky top-0 z-10 bg-white border-b shadow">
    <div class="flex justify-between items-center p-2">
        <div class="flex items-center space-x-4" style="margin-left: 20px;">
            <a href="#" class="text-gray-600 hover:text-gray-800 text-lg"><i class="fas fa-question-circle"></i> Giới thiệu</a>
            <div class="language">
                <span class="check_language hover:text-cyan-400 hover_blue text-lg" id="languageToggle">
                    <i class="fa-solid fa-language"></i> VI <i class="fa-solid fa-caret-down"></i>
                </span>
                <!-- <ul class="show_language" id="languageList">
                    <li>Tiếng Việt</li>
                    <li>English</li>
                    <li>Español</li>
                    <li>Français</li>
                    <li>Deutsch</li>
                    <li>Italiano</li>
                    <li>Português</li>
                    <li>Русский</li>
                    <li>中文 (Zhōngwén)</li>
                    <li>日本語 (Nihongo)</li>
                    <li>한국어 (Hangul)</li>
                    <li>العربية (Al-‘Arabīyah)</li>
                    <li>हिन्दी (Hindi)</li>
                    <li>বাংলা (Bangla)</li>
                    <li>ไทย (Thai)</li>
                    <li>فارسی (Farsi)</li>
                    <li>Türkçe</li>
                    <li>Polski</li>
                    <li>Ελληνικά (Greek)</li>
                    <li>Nederlands</li>
                </ul> -->
            </div>
        </div>
        
        <div class="text-center flex-grow flex justify-center">
            <img src="{{asset('img/logo/imgbb.png')}}" alt="" class="h-6" style="margin-left: 65px">
        </div>
        
        <div class="flex space-x-4" style="margin-right: 62px;">
        <button id="modalOpenBtn" class="flex items-center text-lg">
    <i class="fa-solid fa-cloud-arrow-up mr-2"></i> <!-- Thêm lớp margin-right -->
    <span>Upload</span>
</button>
<button id="loginBtn" class="flex items-center text-lg">
    <i class="fas fa-sign-in-alt text-xl mr-2"></i> <!-- Thêm lớp margin-right -->
    <span>Đăng nhập</span>
</button>


            <div class="flex">
                <button id="modalOpenBtn" class="flex items-center bg-[#2879B0] text-white py-1 px-3 rounded">
                    <span>Đăng ký</span>
                </button>
            </div>
        </div>
    </div>
</header>

@yield("content")

<!-- Modal -->
<div id="uploadModal" class="fixed inset-x-0 top-[4.0rem] bg-gray-900 bg-opacity-70 z-50 hidden flex items-center justify-center">
    <div class="bg-white w-full h-[70%]  shadow-lg max-h-[70vh] overflow-y-auto overflow-hidden " ondrop="dropHandler(event)" ondragover="dragOverHandler(event)">
        <div class="text-left text-xs text-gray-500 leading-tight">
        JPG PNG BMP GIF TIF WEBP HEIC AVIF PDF 32 MB
        </div>
        <button id="closeModal" class="absolute top-4 right-4 text-gray-600 hover:text-gray-800 flex items-center">
            <i class="fas fa-times"></i><span class="text-xs text-gray-500 ml-1">Close</span>
        </button>
        <main class="mt-8 text-center"> 
            <label for="fileInput" class="cursor-pointer">
                <span style="color:#2a80b9" class="fa-7x mt-10 fa-solid fa-cloud-arrow-up my-3"></span>
                <input type="file" id="fileInput" name="files[]" multiple class="hidden" />
            </label>
            <p class="text-2xl font-semi mb-3 text-gray-900 flex flex-wrap justify-center"> Kéo thả hoặc paste (Ctrl + V) ảnh vào đây để upload</p>
            <p class="text-sm text-gray-500 mb-10">Bạn có  <a href="#" class="text-blue-500">tải lên từ máy tính của bạn</a> hoặc <a href="#" class="text-blue-500">thêm địa chỉ ảnh.</a>.</p>   
            <div id="fileList" class="flex justify-center mt-8 space-x-4 flex-wrap"></div>
            <div id="listDownload" class="flex justify-center mt-8 flex-col"></div>
            <div id="autoDeleteSection" class="mt-4 hidden">
                <label class="block text-sm font-bold mb-1" for="auto-delete">
                    Đừng tự động xóa ảnh
                </label>
                <select class="border p-2 mt-2 mx-auto w-full max-w-xs" id="auto-delete">
                    <option value="1">Không xóa</option>
                    <option value="1">Sau 5 phút</option>
                    <option value="7">Sau 15 phút</option>
                    <option value="30">Sau 30 phút</option>
                </select>
            </div>
            <button id="uploadBtn" class="mt-8 bg-green-500 text-white px-6 py-2 rounded hidden">
                TẢI LÊN NGAY
            </button>
        </main>
    </div>
</div>
<div id="modalOverlay" class="bg-opacity-85 fixed inset-0 top-[4.0rem] bg-black z-40 hidden"></div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    
    const uploadedFiles = [];

    document.getElementById('modalOpenBtn').addEventListener('click', function() {
    this.classList.add('underline-on-click'); // Thêm lớp gạch dưới
    document.getElementById('uploadModal').classList.remove('hidden');
    document.getElementById('modalOverlay').classList.remove('hidden');
});


    document.getElementById('modalOpenBtn').addEventListener('click', function() {
        document.getElementById('uploadModal').classList.remove('hidden');
        document.getElementById('modalOverlay').classList.remove('hidden');
    });

    document.getElementById('closeModal').addEventListener('click', function() {
        document.getElementById('uploadModal').classList.add('hidden');
        $('#fileList').empty();
        uploadedFiles.length = 0;
        document.getElementById('autoDeleteSection').classList.add('hidden');
        document.getElementById('uploadBtn').classList.add('hidden');
        document.getElementById('modalOverlay').classList.add('hidden');
    });

    $('#fileInput').on('change', handleFiles);

    // Xử lý thả file vào khu vực modal
    function dropHandler(event) {
        event.preventDefault();
        handleFiles(event);
    }

    function dragOverHandler(event) {
        event.preventDefault();
    }

    //Paste files
    document.getElementById('upload').addEventListener('paste', function(event) {
        // Ngăn chặn hành động mặc định của sự kiện
        event.preventDefault();
        document.getElementById('uploadModal').classList.remove('hidden');
        document.getElementById('modalOverlay').classList.remove('hidden');

        // Lấy dữ liệu từ clipboard
        const items = (event.clipboardData || window.clipboardData).items;

        for (let i = 0; i < items.length; i++) {
            const item = items[i];
            if (item.kind === 'file') {
                const file = item.getAsFile();
                if (file) {
                    handleFiles({ target: { files: [file] } });
                }
            } else if (item.kind === 'string') {
                // Nếu là ảnh từ clipboard
                item.getAsString((url) => {
                    fetch(url)
                        .then(response => response.blob())
                        .then(blob => {
                            const file = new File([blob], 'pasted-image.png', { type: blob.type });
                            handleFiles({ target: { files: [file] } });
                        });
                });
            }
        }
    });

    // Hàm xử lý file
    function handleFiles(event) {
        const files = event.target.files || event.dataTransfer.files;

        for (let i = 0; i < files.length; i++) {
            const file = files[i];

            uploadedFiles.push(file);
            let filePreview;
            const fileExtension = file.name.split('.').pop().toLowerCase();

            // Kiểm tra nếu file là hình ảnh thì hiện ảnh, nếu không hiển thị icon tương ứng
            if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'tif'].includes(fileExtension)) {
                filePreview = `<img alt="${file.name}" title="${file.name}" class="border w-28 h-32 object-cover" src="${URL.createObjectURL(file)}" />`;
            } else {
                let iconClass;
                switch (fileExtension) {
                    case 'rar':
                    case 'zip':
                        iconClass = 'fas fa-file-archive text-yellow-500'; break;
                    case 'pdf':
                        iconClass = 'fas fa-file-pdf text-red-500'; break;
                    case 'doc':
                    case 'docx':
                        iconClass = 'fas fa-file-word text-blue-500'; break;
                    case 'xls':
                    case 'xlsx':
                        iconClass = 'fas fa-file-excel text-green-500'; break;
                    case 'ppt':
                    case 'pptx':
                        iconClass = 'fas fa-file-powerpoint text-orange-500'; break;
                    case 'txt':
                        iconClass = 'fas fa-file-alt text-gray-500'; break;
                    case 'csv':
                        iconClass = 'fas fa-file-csv text-green-600'; break;
                    case 'mp3':
                        iconClass = 'fas fa-file-audio text-purple-500'; break;
                    case 'mp4':
                        iconClass = 'fas fa-file-video text-blue-600'; break;
                    case 'json':
                        iconClass = 'fas fa-file-code text-teal-500'; break;
                    case 'xml':
                        iconClass = 'fas fa-file-code text-orange-600'; break;
                    default:
                        iconClass = 'fas fa-file text-gray-500';
                }
                filePreview = `<i class="${iconClass} border w-28 h-32 text-7xl flex items-center justify-center" title="${file.name}"></i>`;
            }

            const fileDiv = $('<div class="relative inline-block m-1"></div>').append(`
                ${filePreview}
                <button class="absolute top-0 left-0 bg-white rounded-full w-4 h-4 flex items-center justify-center shadow hover:shadow-md transition-shadow duration-300">
                    <i class="fas fa-times text-black-250 text-xs" onclick="removeFile(this)"></i>
                </button>
                <button class="absolute top-4 left-0 bg-white rounded-full w-4 h-4 flex items-center justify-center shadow hover:shadow-md transition-shadow duration-300">
                    <i class="fas fa-pen text-black-200 text-xs"></i>
                </button>
            `);

            $('#fileList').append(fileDiv);
        }

        if ($('#fileList').children().length > 0) {
            document.getElementById('autoDeleteSection').classList.remove('hidden');
            document.getElementById('uploadBtn').classList.remove('hidden');
        }
        else {
            document.getElementById('autoDeleteSection').classList.add('hidden');
            document.getElementById('uploadBtn').classList.add('hidden');
        }
    }

    function removeFile(button) {
        const fileDiv = button.closest('.relative');
        const fileName = fileDiv.querySelector('img, i').getAttribute('title'); // Lấy tên file từ thuộc tính `title`

        const index = uploadedFiles.findIndex(file => file.name === fileName);
        if (index !== -1) {
            uploadedFiles.splice(index, 1);
        }

        fileDiv.remove();

        if (document.getElementById('fileList').children.length === 0) {
            document.getElementById('autoDeleteSection').classList.add('hidden');
            document.getElementById('uploadBtn').classList.add('hidden');
        }
    }

    function copyToClipboard(text) {
    // Tạo một thẻ input tạm thời để chứa nội dung cần sao chép
        const tempInput = document.createElement('input');
        tempInput.value = text;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);
        toastr.success('Sao chép thành công!');
    }

    // Sự kiện click nút upload
    let isUploading = false;
    $('#uploadBtn').on('click', function() {
        if (isUploading) return;
        isUploading = true;
        $(this).prop('disabled', true);
        const maxSize = 10 * 1024 * 1024;
        const invalidFiles = uploadedFiles.filter(file => file.size > maxSize);

        if (invalidFiles.length > 0) {
            toastr.error("Chỉ cho phép upload file dưới 10MB!");
            $(this).prop('disabled', false);
            isUploading = false;
            return; 
        }
        const formData = new FormData();
        uploadedFiles.forEach(file => {
            formData.append('files[]', file);
        });

        formData.append('autoDelete', $('#auto-delete').val());

        $.ajax({
            url: '/upload',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                toastr.success(response.message);
                $('#fileInput').siblings('i').removeClass('fas fa-images').addClass('fas fa-check text-green-500');
                $('#fileInput').removeAttr('id');
                $('#fileList').children().each(function() {
                    $(this).find('button').remove();
                });
                response.downloadLinks.forEach(function(link) {
                    const linkDiv = `
                        <div class="flex justify-center items-center mt-2 flex">
                            <input class="border p-2 w-80 max-w-lg" readonly type="text" value="${link}"/>
                            <button class="bg-gray-200 p-2 ml-2" onclick="copyToClipboard('${link}')">SAO CHÉP</button>
                        </div>
                    `;
                        $('#listDownload').append(linkDiv);
                    });
                document.getElementById('autoDeleteSection').classList.add('hidden');
                document.getElementById('uploadBtn').classList.add('hidden');
            },
            error: function(error) {
                console.error("Error response:", error.responseText);
                toastr.error("Có lỗi xảy ra, vui lòng thử lại!");
            },
            complete: function() {
                $('#uploadBtn').prop('disabled', false);
                isUploading = false;
            }
        });
    });

    // Đăng nhập
    document.getElementById("loginBtn").addEventListener("click", function() {
        window.location.href = "/login";
    });
</script>
@yield("scripts")
</body>
</html>
