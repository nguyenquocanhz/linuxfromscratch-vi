---
description: "Gói Udev chứa các chương trình để tạo động các nút thiết bị (device node)."
---

# 8.76. Udev from Systemd-257.8

Gói Udev chứa các chương trình để tạo động các nút thiết bị (device node).

* **Thời gian dựng ước tính:** 0.1 SBU
* **Dung lượng đĩa cần:** 162 MB

## 8.76.1. Cài đặt Udev

Udev là một phần của gói systemd-257.8. Hãy dùng tệp systemd-257.8.tar.xz làm tarball mã nguồn.

Loại bỏ hai nhóm không cần thiết là `render` và `sgx` khỏi các quy tắc udev mặc định:

```bash
sed -e 's/GROUP="render"/GROUP="video"/' \
    -e 's/GROUP="sgx", //'               \
    -i rules.d/50-udev-default.rules.in
```

Loại bỏ một quy tắc udev đòi hỏi cài đặt Systemd đầy đủ:

```bash
sed -i '/systemd-sysctl/s/^/#/' rules.d/99-systemd.rules.in
```

Điều chỉnh các đường dẫn được ghi cứng tới tệp cấu hình mạng cho bản cài udev độc lập:

```bash
sed -e '/NETWORK_DIRS/s/systemd/udev/' \
    -i src/libsystemd/sd-network/network-util.h
```

Chuẩn bị biên dịch Udev:

```bash
mkdir -p build
cd       build

meson setup ..                  \
      --prefix=/usr             \
      --buildtype=release       \
      -D mode=release           \
      -D dev-kvm-mode=0660      \
      -D link-udev-shared=false \
      -D logind=false           \
      -D vconsole=false
```

**Ý nghĩa của các tùy chọn meson:**

**`--buildtype=release`**

> Tùy chọn này ghi đè kiểu dựng mặc định (“debug”), vốn tạo ra các tệp nhị phân chưa tối ưu.

**`-D mode=release`**

> Tắt một số tính năng mà upstream coi là còn thử nghiệm.

**`-D dev-kvm-mode=0660`**

> Quy tắc udev mặc định sẽ cho phép mọi người dùng truy cập `/dev/kvm`. Các biên tập viên cho rằng điều này nguy hiểm. Tùy chọn này ghi đè nó.

**`-D link-udev-shared=false`**

> Tùy chọn này ngăn udev liên kết với thư viện dùng chung nội bộ của systemd, `libsystemd-shared`. Thư viện này được thiết kế để nhiều thành phần Systemd cùng dùng, và quá cồng kềnh cho bản cài chỉ có udev.

**`-D logind=false -D vconsole=false`**

> Các tùy chọn này ngăn việc tạo một số tệp quy tắc udev thuộc các thành phần Systemd khác mà chúng ta sẽ không cài.

Lấy danh sách các helper udev đi kèm và lưu vào một biến môi trường (việc export không thật sự cần thiết, nhưng giúp dựng dưới người dùng thường hoặc dùng trình quản lý gói dễ hơn):

```bash
export udev_helpers=$(grep "'name' :" ../src/udev/meson.build | \
                      awk '{print $3}' | tr -d ",'" | grep -v 'udevadm')
```

Chỉ dựng các thành phần cần cho udev:

```bash
ninja udevadm systemd-hwdb                                           \
      $(ninja -n | grep -Eo '(src/(lib)?udev|rules.d|hwdb.d)/[^ ]*') \
      $(realpath libudev.so --relative-to .)                         \
      $udev_helpers
```

Cài đặt gói:

```bash
install -vm755 -d {/usr/lib,/etc}/udev/{hwdb.d,rules.d,network}
install -vm755 -d /usr/{lib,share}/pkgconfig
install -vm755 udevadm                             /usr/bin/
install -vm755 systemd-hwdb                        /usr/bin/udev-hwdb
ln      -svfn  ../bin/udevadm                      /usr/sbin/udevd
cp      -av    libudev.so{,*[0-9]}                 /usr/lib/
install -vm644 ../src/libudev/libudev.h            /usr/include/
install -vm644 src/libudev/*.pc                    /usr/lib/pkgconfig/
install -vm644 src/udev/*.pc                       /usr/share/pkgconfig/
install -vm644 ../src/udev/udev.conf               /etc/udev/
install -vm644 rules.d/* ../rules.d/README         /usr/lib/udev/rules.d/
install -vm644 $(find ../rules.d/*.rules \
                      -not -name '*power-switch*') /usr/lib/udev/rules.d/
install -vm644 hwdb.d/*  ../hwdb.d/{*.hwdb,README} /usr/lib/udev/hwdb.d/
install -vm755 $udev_helpers                       /usr/lib/udev
install -vm644 ../network/99-default.link          /usr/lib/udev/network
```

Cài một số quy tắc tùy chỉnh và tệp hỗ trợ hữu ích trong môi trường LFS:

```bash
tar -xvf ../../udev-lfs-20230818.tar.xz
make -f udev-lfs-20230818/Makefile.lfs install
```

Cài các trang man:

```bash
tar -xf ../../systemd-man-pages-257.8.tar.xz                            \
    --no-same-owner --strip-components=1                              \
    -C /usr/share/man --wildcards '*/udev*' '*/libudev*'              \
                                  '*/systemd.link.5'                  \
                                  '*/systemd-'{hwdb,udevd.service}.8

sed 's|systemd/network|udev/network|'                                 \
    /usr/share/man/man5/systemd.link.5                                \
  > /usr/share/man/man5/udev.link.5

sed 's/systemd\(\\\?-\)/udev\1/' /usr/share/man/man8/systemd-hwdb.8   \
                               > /usr/share/man/man8/udev-hwdb.8

sed 's|lib.*udevd|sbin/udevd|'                                        \
    /usr/share/man/man8/systemd-udevd.service.8                       \
  > /usr/share/man/man8/udevd.8

rm /usr/share/man/man*/systemd*
```

Cuối cùng, hủy đặt (unset) biến `udev_helpers`:

```bash
unset udev_helpers
```

## 8.76.2. Configuring Udev

Thông tin về các thiết bị phần cứng được lưu trong các thư mục `/etc/udev/hwdb.d` và `/usr/lib/udev/hwdb.d`. `Udev` cần thông tin đó được biên dịch thành một cơ sở dữ liệu nhị phân `/etc/udev/hwdb.bin`. Tạo cơ sở dữ liệu ban đầu:

```bash
udev-hwdb update
```

Lệnh này cần được chạy mỗi khi thông tin phần cứng được cập nhật.

## 8.76.3. Nội dung của Udev

* **Chương trình được cài:** udevadm, udevd (liên kết mềm tới udevadm) và udev-hwdb
* **Thư viện được cài:** libudev.so
* **Thư mục được cài:** /etc/udev và /usr/lib/udev

### Mô tả ngắn

* `udevadm` — Công cụ quản trị udev đa năng: điều khiển daemon udevd, cung cấp thông tin từ cơ sở dữ liệu Udev, theo dõi uevent, chờ uevent hoàn tất, kiểm tra cấu hình Udev và kích hoạt uevent cho một thiết bị cho trước
* `udevd` — Một daemon lắng nghe uevent trên netlink socket, tạo thiết bị và chạy các chương trình bên ngoài đã cấu hình để đáp lại các uevent đó
* `udev-hwdb` — Cập nhật hoặc truy vấn cơ sở dữ liệu phần cứng.
* `libudev` — Giao diện thư viện tới thông tin thiết bị udev
* `/etc/udev` — Chứa các tệp cấu hình Udev, quyền thiết bị và quy tắc đặt tên thiết bị

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/udev.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/udev.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/udev.html)
