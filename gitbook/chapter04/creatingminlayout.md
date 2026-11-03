---
description: "Ở mục này, chúng ta bắt đầu đưa vào hệ thống tệp LFS những thành phần sẽ tạo nên hệ thống Linux cuối cùng. Bước đầu tiên là tạo một cây thư mục tối giản, đ"
---

# 4.2. Tạo bố cục thư mục tối giản trong hệ thống tệp LFS

Ở mục này, chúng ta bắt đầu đưa vào hệ thống tệp LFS những thành phần sẽ tạo nên hệ thống Linux cuối cùng. Bước đầu tiên là tạo một cây thư mục tối giản, để các chương trình biên dịch trong [Chương 6](../chapter06/chapter06.md) (cùng glibc và libstdc++ trong [Chương 5](../chapter05/chapter05.md)) có thể được cài vào vị trí cuối cùng của chúng. Làm vậy để các chương trình tạm đó bị ghi đè khi bản chính thức được dựng ở [Chương 8](../chapter08/chapter08.md).

Hãy tạo bố cục thư mục cần thiết bằng cách chạy các lệnh sau với tư cách `root`:

```bash
mkdir -pv $LFS/{etc,var} $LFS/usr/{bin,lib,sbin}

for i in bin lib sbin; do
  ln -sv usr/$i $LFS/$i
done

case $(uname -m) in
  x86_64) mkdir -pv $LFS/lib64 ;;
esac
```

Các chương trình trong [Chương 6](../chapter06/chapter06.md) sẽ được biên dịch bằng trình biên dịch chéo (xem thêm chi tiết ở mục [Ghi chú kỹ thuật về toolchain](../partintro/toolchaintechnotes.md)). Trình biên dịch chéo này sẽ được cài vào một thư mục riêng để tách khỏi các chương trình khác. Vẫn với tư cách `root`, hãy tạo thư mục đó bằng lệnh:

```bash
mkdir -pv $LFS/tools
```

{% hint style="info" %}
**Ghi chú**

Các biên tập viên LFS cố ý quyết định không dùng thư mục `/usr/lib64`. Có nhiều bước được thực hiện để chắc chắn toolchain sẽ không dùng nó. Nếu vì lý do nào đó thư mục này xuất hiện (do bạn làm sai hướng dẫn, hoặc do bạn cài một gói nhị phân tạo ra nó sau khi hoàn tất LFS), nó có thể làm hỏng hệ thống của bạn. Hãy luôn đảm bảo thư mục này không tồn tại.
{% endhint %}

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter04/creatingminlayout.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter04/creatingminlayout.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter04/creatingminlayout.html)
