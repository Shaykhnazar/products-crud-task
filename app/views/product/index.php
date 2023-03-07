<div class="container">
    <div class="column content-center">
        <div class="product_add_form">
            <h3 style="margin-left: 20%;">Tovar qo'shish</h3>
            <form action="" name="form">
                <div class="product-form-group">
                    <input type="text" placeholder="Tovar nomi" name="name" class="u-input-4 product_add_input" required="">
                </div>
                <div class="product-form-group" style="width: 100%; display: flex; flex: content-box">
                    <input type="text" placeholder="SKU" name="sku" class="u-input-5 product_add_input" required="required" style="width: 70%">
                    <button class="sku_generate_btn">Generatsiya</button>
                </div>
                <div>
                    <a href="#" class="u-btn">Saqlash</a>
                </div>
            </form>
        </div>
    </div>
    <div class="column">
        <div class="sku_form">
            <h3 style="margin-left: 40%;">Sozlamalar</h3>
            <form action="" name="form">
                <div class="u-form-horizontal">
                    <div class="sku_form_group">
                        <label for="prefix" class="u-label">Prefiks</label>
                        <input type="text" placeholder="PRO" id="prefix" name="prefix" class="u-input-1 sku_input" required="">
                    </div>
                    <div class="sku_form_group">
                        <label for="start_value" class="u-label">Boshlash qiymati</label>
                        <input type="text" placeholder="10000" id="start_value" name="start_value" class="u-input-2 sku_input" required="required">
                    </div>
                    <div class="sku_form_group">
                        <label for="suffiks" class="u-label">Suffiks</label>
                        <input type="text" placeholder="-D" id="suffiks" name="suffiks" class="u-input-3 sku_input">
                    </div>
                </div>
                <div class="u-row">
                    <a href="#" class="sku_save_btn content-center">Saqlash</a>
                </div>
            </form>
        </div>
    </div>
</div>

<div>
    <h2 class="u-text-1">Tovarlar</h2>
    <table class="u-table-1">
        <colgroup>
            <col width="33.3%">
            <col width="33.2%">
            <col width="33.4%">
        </colgroup>
        <thead class="u-table-header-1">
            <tr style="height: 100px;">
                <th class="u-table-cell">Nomi</th>
                <th class="u-table-cell">SKU</th>
                <th>Amal</th>
            </tr>
        </thead>
        <tbody class="u-table-body">
            <tr class="u-table-row">
                <td class="u-table-cell-4">Televizor</td>
                <td class="u-table-cell-5">PRO10001-D</td>
                <td class="u-table-cell-actions">
                    <span class="u-icon"><img src="/public/images/1828911.png" alt=""  class="u-icon-img"></span>
                    <span class="u-icon"><img src="/public/images/565491.png" alt="" class="u-icon-img"></span>
                </td>
            </tr>
        </tbody>
    </table>
</div>