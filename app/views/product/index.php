<div class="container">
    <div class="column content-center">
        <div class="product_add_form">
            <h3 style="margin-left: 20%;">Tovar qo'shish</h3>
            <form action="/api/products/store" method="POST" id="product_add_form" data-form="add">
                <div class="product_form_group">
                    <input type="text" placeholder="Tovar nomi" name="name" class="u-input-4 product_add_input" required="">
                </div>
                <div class="product_form_group" style="width: 100%; display: flex; flex: content-box">
                    <input type="text" placeholder="SKU" name="sku" class="u-input-5 product_add_input" required="required" style="width: 70%" data-form="add">
                    <button class="sku_generate_btn">Generatsiya</button>
                </div>
                <div>
                    <input type="submit" value="Saqlash" class="u-btn content-center"/>
                </div>
            </form>
        </div>
    </div>
    <div class="column">
        <div class="sku_form">
            <h3 style="margin-left: 40%;">Sozlamalar</h3>
            <form action="/api/sku/update" method="POST" id="sku_form">
                <div class="u-form-horizontal">
                    <div class="sku_form_group">
                        <label for="prefix" class="u-label">Prefiks</label>
                        <input type="text" placeholder="PRO" id="prefix" name="prefix" class="u-input-1 sku_input" required="">
                    </div>
                    <div class="sku_form_group">
                        <label for="start_value" class="u-label">Boshlash qiymati</label>
                        <input type="text" placeholder="10000" id="start_value" name="index" class="u-input-2 sku_input" required="required">
                    </div>
                    <div class="sku_form_group">
                        <label for="suffiks" class="u-label">Suffiks</label>
                        <input type="text" placeholder="-D" id="suffiks" name="suffix" class="u-input-3 sku_input">
                    </div>
                </div>
                <div class="u-row">
                    <input type="submit" value="Saqlash" class="sku_save_btn content-center" />
                </div>
            </form>
        </div>
    </div>
</div>

<div>
    <h2 class="u-text-1">Tovarlar</h2>
    <table class="products-table">
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
        <tbody class="u-table-body" id="products-list">
        </tbody>
    </table>
    <div id="pagination" class="pagination">
    </div>
</div>


<!-- Edit Modal -->
<div id="editModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <div class="modal-header">
            <span class="close_model_span">&times;</span>
            <h2>Tovarni tahrirlash</h2>
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="column content-center">
                    <div class="product_add_form">
                        <form action="/api/products/update" method="POST" id="product_edit_form" data-form="edit">
                            <div class="product_form_group">
                                <input type="text" placeholder="Tovar nomi" name="name" class="u-input-4 product_add_input" required="">
                            </div>
                            <div class="product_form_group" style="width: 100%; display: flex; flex: content-box">
                                <input type="text" placeholder="SKU" name="sku" class="u-input-5 product_add_input" required="required" style="width: 70%" data-form="edit">
                                <button class="sku_generate_btn">Generatsiya</button>
                            </div>
                            <input type="hidden" name="id" value="">
                            <div>
                                <input type="submit" value="Saqlash" class="u-btn content-center"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<!--        <div class="modal-footer">-->
<!--            <h3>Modal Footer</h3>-->
<!--        </div>-->
    </div>

</div>