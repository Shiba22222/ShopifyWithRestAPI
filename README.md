1. Chạy lệnh composer install.
2. Chạy lệnh php artisan serve.
3. Dùng ngrok để có domain thao tác api với shopify.
4. Vào đường dẫn: http://127.0.0.1:8000/
- Ấn Sunmit để đăng kí các gói webhook như createProductWebhook, updateProductWebhook, DeleteProductWebhook.
- Nếu có sẵn sản phẩm trên Shopify thì dữ liệu đó sẽ được lưu vào DB.
5. Chạy lệnh php artisan queue:work để bắt đầu chạy hàng đợi.
6. Lên trang: https://huskadian2.myshopify.com/admin để thực hiện các thao tác Thêm, Xóa, Sửa trên Shopify.
- sản phẩm sau khi Thêm sẽ được lưu ở Shopify và DB Local mà không cần làm gì thêm.
- Xóa sản phẩm ở Shopify thì dữ liệu trong DB cũng sẽ bị xóa.
- Sửa sản phẩm ở Shopify thì sẽ sửa dữ liệu ở DB.
7. Vào đường dẫn: http://127.0.0.1:8000/admin/get-product
- Sản phẩm khi thêm ở Shopify sẽ được truyền ra view này.
- Khi ấn nút Xóa thì sẽ xóa sản phẩm ở Local và cũng xóa sản phẩm ở Shopify.
- Khi ấn nút Sửa và sửa sản phẩm ở Local thì sản phẩm ở Shopify cũng sẽ được sẽ theo như ở Local.

