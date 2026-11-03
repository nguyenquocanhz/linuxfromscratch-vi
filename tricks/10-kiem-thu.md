---
title: Bộ kiểm thử — chỗ nào được lười, chỗ nào tuyệt đối không
pages: chapter04/abouttestsuites.html, chapter08/gcc.html, chapter08/glibc.html
tags: kiểm thử
---
Chạy hết test ở Chương 8 có thể mất lâu hơn cả thời gian dựng. Ưu tiên thế này:

- **Bắt buộc chạy**: Glibc, GCC, Binutils (và GMP, MPFR như sách nhấn mạnh). Toolchain hỏng thì mọi gói sau đều hỏng theo.
- **Có vài test lỗi là bình thường**: sách luôn liệt kê các test "known to fail". So kết quả của bạn với danh sách đó trước khi hoảng.
- Gói nhỏ (ví dụ man-pages, less) mà bạn vội thì bỏ test cũng chấp nhận được ở lần dựng đầu tiên.

So kết quả với người khác: `../contrib/test_summary | grep -A7 Summ` (GCC) rồi đối chiếu tại trang [buildlogs của LFS](https://www.linuxfromscratch.org/lfs/build-logs/).
