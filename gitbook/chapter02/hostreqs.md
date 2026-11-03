---
description: "Các biên tập viên LFS khuyến nghị CPU có ít nhất bốn nhân và hệ thống có ít nhất 8 GB bộ nhớ. Các máy cũ không đạt yêu cầu này vẫn chạy được, nhưng thời gi"
---

<details>

<summary>Trick lỏ: Đừng làm trên máy thật — dựng LFS trong máy ảo hoặc file ảnh đĩa</summary>

Lần đầu làm LFS, gõ nhầm một lệnh với quyền root là đủ hỏng hệ thống chủ. Cách an toàn nhất:

* Cài một distro nhẹ (Debian, Ubuntu Server, Fedora...) trong **VirtualBox/QEMU/VMware** rồi làm LFS trong đó. Snapshot máy ảo trước mỗi chương lớn.
* Không muốn chia lại ổ cứng? Dùng **file ảnh đĩa** thay cho phân vùng thật:

```bash
truncate -s 30G ~/lfs.img                       # file thưa, chỉ tốn chỗ khi ghi thật
sudo losetup -fP --show ~/lfs.img               # in ra ví dụ /dev/loop0
sudo fdisk /dev/loop0                           # tạo phân vùng như sách hướng dẫn
sudo mkfs -v -t ext4 /dev/loop0p1
```

Sau này file `lfs.img` boot thẳng được bằng QEMU (xem trick ở Chương 10). Gỡ bằng `sudo losetup -d /dev/loop0`.

[Tất cả trick lỏ →](../trick-lo.md#chay-trong-may-ao)

</details>

# 2.2. Yêu cầu đối với hệ thống host

## 2.2.1. Phần cứng

Các biên tập viên LFS khuyến nghị CPU có ít nhất bốn nhân và hệ thống có ít nhất 8 GB bộ nhớ. Các máy cũ không đạt yêu cầu này vẫn chạy được, nhưng thời gian dựng các gói sẽ lâu hơn đáng kể so với số liệu trong sách.

## 2.2.2. Phần mềm

Máy host của bạn cần có các phần mềm sau, với phiên bản tối thiểu như nêu. Hầu hết bản phân phối Linux hiện đại đều đáp ứng được. Cũng lưu ý rằng nhiều bản phân phối đặt các tệp header của phần mềm vào gói riêng, thường có dạng `<package-name>-devel` hoặc `<package-name>-dev`. Hãy nhớ cài chúng nếu bản phân phối của bạn có.

Các phiên bản cũ hơn của những gói phần mềm được liệt kê có thể vẫn chạy, nhưng chưa được kiểm thử.

* **Bash-3.2** (/bin/sh phải là symlink hoặc hard link tới bash)
* **Binutils-2.13.1** (không khuyến nghị các phiên bản trên 2.45 vì chưa được kiểm thử)
* **Bison-2.7** (/usr/bin/yacc phải là liên kết tới bison hoặc một script nhỏ chạy bison)
* **Coreutils-8.1**
* **Diffutils-2.8.1**
* **Findutils-4.2.31**
* **Gawk-4.0.1** (/usr/bin/awk phải là liên kết tới gawk)
* **GCC-5.4** kèm trình biên dịch C++, `g++` (không khuyến nghị các phiên bản trên 15.2.0 vì chưa được kiểm thử). Các thư viện chuẩn C và C++ (kèm header) cũng phải có, để trình biên dịch C++ dựng được các chương trình hosted
* **Grep-2.5.1a**
* **Gzip-1.3.12**
* **Linux Kernel-5.4**

  Lý do có yêu cầu về phiên bản kernel là ta chỉ định phiên bản đó khi dựng `glibc` ở [Chương 5](../chapter05/chapter05.md) và [Chương 8](../chapter08/chapter08.md), nên các giải pháp tạm cho kernel cũ không được bật và `glibc` biên dịch ra sẽ nhanh hơn và nhỏ hơn đôi chút. Tính đến tháng 12/2024, 5.4 là bản kernel cũ nhất vẫn được các nhà phát triển kernel hỗ trợ. Một số bản kernel cũ hơn 5.4 có thể vẫn được các nhóm bên thứ ba hỗ trợ, nhưng chúng không được coi là bản kernel upstream chính thức; xem chi tiết tại [https://kernel.org/category/releases.html](https://kernel.org/category/releases.html).

  Nếu kernel của máy host cũ hơn 5.4, bạn cần thay bằng bản mới hơn. Có hai cách. Thứ nhất, xem nhà cung cấp Linux của bạn có gói kernel 5.4 trở lên không. Nếu có, bạn có thể cài nó. Nếu nhà cung cấp không có gói kernel phù hợp, hoặc bạn không muốn cài, bạn có thể tự biên dịch kernel. Hướng dẫn biên dịch kernel và cấu hình bộ nạp khởi động (giả sử máy host dùng GRUB) nằm ở [Chương 10](../chapter10/chapter10.md).

  Chúng tôi yêu cầu kernel của máy host hỗ trợ pseudo terminal (PTY) UNIX 98. Tính năng này đã được bật trên mọi bản phân phối desktop hoặc server dùng kernel Linux 5.4 trở lên. Nếu bạn tự dựng kernel host, hãy bảo đảm `CONFIG_UNIX98_PTYS` được đặt là `y` trong cấu hình kernel.
* **M4-1.4.10**
* **Make-4.0**
* **Patch-2.5.4**
* **Perl-5.8.8**
* **Python-3.4**
* **Sed-4.1.5**
* **Tar-1.22**
* **Texinfo-5.0**
* **Xz-5.0.0**

{% hint style="warning" %}
**Quan trọng**

Lưu ý rằng các symlink nêu ở trên là bắt buộc để dựng hệ thống LFS theo hướng dẫn trong sách này. Các symlink trỏ tới phần mềm khác (như dash, mawk, v.v.) có thể hoạt động, nhưng không được nhóm phát triển LFS kiểm thử hay hỗ trợ, và có thể buộc bạn làm khác hướng dẫn hoặc cần thêm patch cho một số gói.
{% endhint %}

## 

Để xem máy host của bạn có đủ phiên bản phù hợp và có khả năng biên dịch chương trình hay không, hãy chạy các lệnh sau:

```bash
cat > version-check.sh << "EOF"
#!/bin/bash
# A script to list version numbers of critical development tools

# If you have tools installed in other directories, adjust PATH here AND
# in ~lfs/.bashrc (section 4.4) as well.

LC_ALL=C 
PATH=/usr/bin:/bin

bail() { echo "FATAL: $1"; exit 1; }
grep --version > /dev/null 2> /dev/null || bail "grep does not work"
sed '' /dev/null || bail "sed does not work"
sort   /dev/null || bail "sort does not work"

ver_check()
{
   if ! type -p $2 &>/dev/null
   then 
     echo "ERROR: Cannot find $2 ($1)"; return 1; 
   fi
   v=$($2 --version 2>&1 | grep -E -o '[0-9]+\.[0-9\.]+[a-z]*' | head -n1)
   if printf '%s\n' $3 $v | sort --version-sort --check &>/dev/null
   then 
     printf "OK:    %-9s %-6s >= $3\n" "$1" "$v"; return 0;
   else 
     printf "ERROR: %-9s is TOO OLD ($3 or later required)\n" "$1"; 
     return 1; 
   fi
}

ver_kernel()
{
   kver=$(uname -r | grep -E -o '^[0-9\.]+')
   if printf '%s\n' $1 $kver | sort --version-sort --check &>/dev/null
   then 
     printf "OK:    Linux Kernel $kver >= $1\n"; return 0;
   else 
     printf "ERROR: Linux Kernel ($kver) is TOO OLD ($1 or later required)\n" "$kver"; 
     return 1; 
   fi
}

# Coreutils first because --version-sort needs Coreutils >= 7.0
ver_check Coreutils      sort     8.1 || bail "Coreutils too old, stop"
ver_check Bash           bash     3.2
ver_check Binutils       ld       2.13.1
ver_check Bison          bison    2.7
ver_check Diffutils      diff     2.8.1
ver_check Findutils      find     4.2.31
ver_check Gawk           gawk     4.0.1
ver_check GCC            gcc      5.4
ver_check "GCC (C++)"    g++      5.4
ver_check Grep           grep     2.5.1a
ver_check Gzip           gzip     1.3.12
ver_check M4             m4       1.4.10
ver_check Make           make     4.0
ver_check Patch          patch    2.5.4
ver_check Perl           perl     5.8.8
ver_check Python         python3  3.4
ver_check Sed            sed      4.1.5
ver_check Tar            tar      1.22
ver_check Texinfo        texi2any 5.0
ver_check Xz             xz       5.0.0
ver_kernel 5.4

if mount | grep -q 'devpts on /dev/pts' && [ -e /dev/ptmx ]
then echo "OK:    Linux Kernel supports UNIX 98 PTY";
else echo "ERROR: Linux Kernel does NOT support UNIX 98 PTY"; fi

alias_check() {
   if $1 --version 2>&1 | grep -qi $2
   then printf "OK:    %-4s is $2\n" "$1";
   else printf "ERROR: %-4s is NOT $2\n" "$1"; fi
}
echo "Aliases:"
alias_check awk GNU
alias_check yacc Bison
alias_check sh Bash

echo "Compiler check:"
if printf "int main(){}" | g++ -x c++ -
then echo "OK:    g++ works";
else echo "ERROR: g++ does NOT work"; fi
rm -f a.out

if [ "$(nproc)" = "" ]; then
   echo "ERROR: nproc is not available or it produces empty output"
else
   echo "OK: nproc reports $(nproc) logical cores are available"
fi
EOF

bash version-check.sh
```

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter02/hostreqs.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter02/hostreqs.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter02/hostreqs.html)
