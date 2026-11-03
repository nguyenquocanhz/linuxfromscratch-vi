---
description: "Một số biến môi trường là cần thiết để hỗ trợ ngôn ngữ bản địa. Thiết lập đúng chúng sẽ giúp:"
---

<details>

<summary>Trick lỏ: Cho LFS nói tiếng Việt và chạy giờ Việt Nam</summary>

Khi cài locale ở bước Glibc, thêm locale tiếng Việt:

```bash
localedef -i vi_VN -f UTF-8 vi_VN.UTF-8
```

Múi giờ: thay vì chạy `tzselect` dò từng bước, đặt thẳng:

```bash
ln -sfv /usr/share/zoneinfo/Asia/Ho_Chi_Minh /etc/localtime
```

Ở Mục 9.7, muốn giao diện vẫn tiếng Anh (dễ tra lỗi trên mạng) nhưng ngày giờ, tiền tệ kiểu Việt:

```bash
cat > /etc/profile.d/i18n.sh << "EOF2"
export LANG=en_US.UTF-8
export LC_TIME=vi_VN.UTF-8
EOF2
```

Gõ tiếng Việt có dấu trên console thô không được — đợi lên BLFS, cài môi trường đồ họa và IBus/Fcitx5 với bộ gõ Unikey/Bamboo.

[Tất cả trick lỏ →](../trick-lo.md#tieng-viet-gio-vn)

</details>

# 9.7. Configuring the System Locale

Một số biến môi trường là cần thiết để hỗ trợ ngôn ngữ bản địa. Thiết lập đúng chúng sẽ giúp:

* Đầu ra của các chương trình được dịch sang ngôn ngữ của bạn
* Phân loại ký tự đúng thành chữ cái, chữ số và các lớp khác. Điều này cần thiết để `bash` nhận đúng các ký tự không phải ASCII trong dòng lệnh ở các locale không phải tiếng Anh
* Thứ tự sắp xếp theo bảng chữ cái đúng với quốc gia
* Khổ giấy mặc định phù hợp
* Định dạng đúng các giá trị tiền tệ, thời gian và ngày tháng

Hãy thay `<ll>` bên dưới bằng mã hai chữ cái của ngôn ngữ bạn muốn (ví dụ `en`) và `<CC>` bằng mã hai chữ cái của quốc gia tương ứng (ví dụ `GB`). `<charmap>` cần được thay bằng charmap chuẩn (canonical) của locale bạn chọn. Cũng có thể có thêm các bổ ngữ tùy chọn như `@euro`.

Bạn có thể lấy danh sách tất cả locale mà Glibc hỗ trợ bằng lệnh sau:

```bash
locale -a
```

Một charmap có thể có nhiều bí danh, ví dụ `ISO-8859-1` còn được gọi là `iso8859-1` và `iso88591`. Một số ứng dụng không xử lý đúng các tên đồng nghĩa này (ví dụ, yêu cầu `UTF-8` phải viết là `UTF-8` chứ không phải `utf8`), nên trong hầu hết trường hợp, an toàn nhất là chọn tên chuẩn của locale. Để xác định tên chuẩn, hãy chạy lệnh sau, trong đó `<locale name>` là kết quả do `locale -a` in ra cho locale bạn muốn (trong ví dụ của chúng ta là `en_GB.iso88591`).

```bash
LC_ALL=<locale name> locale charmap
```

Với locale `en_GB.iso88591`, lệnh trên sẽ in ra:

```text
ISO-8859-1
```

Kết quả là thiết lập locale cuối cùng là `en_GB.ISO-8859-1`. Điều quan trọng là phải thử locale tìm được bằng cách trên trước khi thêm vào các tệp khởi động của Bash:

```bash
LC_ALL=<locale name> locale language
LC_ALL=<locale name> locale charmap
LC_ALL=<locale name> locale int_curr_symbol
LC_ALL=<locale name> locale int_prefix
```

Các lệnh trên phải in ra tên ngôn ngữ, bảng mã mà locale sử dụng, đơn vị tiền tệ địa phương, và tiền tố cần quay trước số điện thoại để gọi vào quốc gia đó. Nếu bất kỳ lệnh nào ở trên thất bại với thông báo tương tự như bên dưới, nghĩa là locale của bạn chưa được cài ở Chương 8 hoặc không được bản cài Glibc mặc định hỗ trợ.

```text
locale: Cannot set LC_* to default locale: No such file or directory
```

Nếu gặp tình huống này, bạn nên cài locale mong muốn bằng lệnh `localedef`, hoặc cân nhắc chọn locale khác. Các hướng dẫn tiếp theo giả định Glibc không báo lỗi nào như vậy.

Các gói khác cũng có thể hoạt động sai (nhưng không nhất thiết hiện thông báo lỗi) nếu tên locale không đúng kỳ vọng của chúng. Trong những trường hợp đó, tìm hiểu cách các bản phân phối Linux khác hỗ trợ locale của bạn có thể cho bạn thông tin hữu ích.

Chương trình shell `/bin/bash` (sau đây gọi là “shell”) dùng một tập các tệp khởi động để giúp tạo môi trường chạy. Mỗi tệp có công dụng riêng và có thể ảnh hưởng khác nhau đến môi trường đăng nhập và môi trường tương tác. Các tệp trong thư mục `/etc` cung cấp thiết lập toàn cục. Nếu có các tệp tương đương trong thư mục chủ, chúng có thể ghi đè thiết lập toàn cục.

Một shell đăng nhập tương tác được khởi chạy sau khi đăng nhập thành công, qua `/bin/login`, bằng cách đọc tệp `/etc/passwd`. Một shell tương tác không đăng nhập được khởi chạy từ dòng lệnh (ví dụ `[prompt]$``/bin/bash`). Shell không tương tác thường xuất hiện khi một shell script đang chạy. Nó không tương tác vì đang xử lý script chứ không chờ người dùng nhập giữa các lệnh.

Tạo tệp `/etc/profile` sau khi đã xác định đúng thiết lập locale để đặt locale mong muốn, nhưng hãy đặt locale `C.UTF-8` nếu đang chạy trong console Linux (để chương trình không xuất ra những ký tự mà console Linux không hiển thị được):

```bash
cat > /etc/profile << "EOF"
# Begin /etc/profile

for i in $(locale); do
  unset ${i%=*}
done

if [[ "$TERM" = linux ]]; then
  export LANG=C.UTF-8
else
  export LANG=<ll>_<CC>.<charmap><@modifiers>
fi

# End /etc/profile
EOF
```

Locale `C` (mặc định) và `en_US` (locale khuyến nghị cho người dùng tiếng Anh Mỹ) là khác nhau. `C` dùng bộ ký tự US-ASCII 7 bit, và coi các byte có bit cao được đặt là ký tự không hợp lệ. Vì vậy, ví dụ, lệnh `ls` thay chúng bằng dấu hỏi trong locale đó. Ngoài ra, nếu gửi thư chứa các ký tự như vậy từ Mutt hoặc Pine, thư gửi đi sẽ không tuân thủ RFC (bộ ký tự trong thư được ghi là `unknown 8-bit`). Bạn chỉ nên dùng locale `C` nếu chắc chắn sẽ không bao giờ cần ký tự 8 bit.

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter09/locale.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter09/locale.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter09/locale.html)
