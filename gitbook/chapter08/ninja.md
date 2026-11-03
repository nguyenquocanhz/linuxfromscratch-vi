---
description: "Khi chạy, ninja thường dùng số tiến trình song song nhiều nhất có thể. Mặc định là số nhân của hệ thống cộng thêm hai. Điều này có thể làm CPU quá nóng hoặ"
---

# 8.56. Ninja-1.13.1

Ninja là hệ thống dựng nhỏ gọn, tập trung vào tốc độ.

* **Thời gian dựng ước tính:** 0.2 SBU
* **Dung lượng đĩa cần:** 43 MB

## 8.56.1. Cài đặt Ninja

Khi chạy, `ninja` thường dùng số tiến trình song song nhiều nhất có thể. Mặc định là số nhân của hệ thống cộng thêm hai. Điều này có thể làm CPU quá nóng hoặc khiến hệ thống hết bộ nhớ. Khi gọi `ninja` từ dòng lệnh, truyền tham số -jN sẽ giới hạn số tiến trình song song. Một số gói nhúng việc chạy `ninja` bên trong và không chuyển tham số -j cho nó.

Dùng quy trình *tùy chọn* dưới đây cho phép người dùng giới hạn số tiến trình song song qua biến môi trường NINJAJOBS. **Ví dụ**, đặt:

```text
export NINJAJOBS=4
```

sẽ giới hạn `ninja` ở bốn tiến trình song song.

Nếu muốn, làm cho `ninja` nhận biết biến môi trường NINJAJOBS bằng cách chạy trình soạn thảo luồng:

```bash
sed -i '/int Guess/a \
  int   j = 0;\
  char* jobs = getenv( "NINJAJOBS" );\
  if ( jobs != NULL ) j = atoi( jobs );\
  if ( j > 0 ) return j;\
' src/ninja.cc
```

Dựng Ninja bằng:

```bash
python3 configure.py --bootstrap --verbose
```

**Ý nghĩa của tùy chọn dựng:**

**`--bootstrap`**

> Tham số này buộc Ninja tự dựng lại cho hệ thống hiện tại.

**`--verbose`**

> Tham số này khiến `configure.py` hiển thị tiến trình dựng Ninja.

Các bài kiểm thử của gói không chạy được trong môi trường chroot. Chúng cần [cmake](https://www.linuxfromscratch.org/blfs/view/12.4/general/cmake.html). Tuy nhiên chức năng cơ bản của gói vốn đã được kiểm tra khi nó tự dựng lại (với tùy chọn `--bootstrap`).

Cài đặt gói:

```bash
install -vm755 ninja /usr/bin/
install -vDm644 misc/bash-completion /usr/share/bash-completion/completions/ninja
install -vDm644 misc/zsh-completion  /usr/share/zsh/site-functions/_ninja
```

## 8.56.2. Nội dung của Ninja

* **Chương trình được cài:** ninja

### Mô tả ngắn

* `ninja` — là hệ thống dựng Ninja

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/ninja.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/ninja.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/ninja.html)
