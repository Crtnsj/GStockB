<div>
    <form action="index.php?uc=order&action=validForm" method="post">
        <select name="type_co" id="">
            <option value="entrée">Entrée</option>
            <option value="sortie">Sortie</option>
        </select>
        <table id="stockTable">
            <thead>
                <tr>
                    <th>Stock</th>
                    <th>Quantité</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select name="stock1">
                            <?php foreach ($stocks as $stock) { ?>
                                <option value="<?php echo $stock->nom_st; ?>"><?php echo $stock->nom_st; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td><input type="number" name="qte1" id=""></td>
                </tr>
            </tbody>
        </table>
        <input type="hidden" name="numberOfStocks" id="numberOfStocks" value="1">
        <button type="button" onclick="addRow()">Ajouter une ligne</button>
        <input type="submit" value="Valider la création">
    </form>
</div>

<script>
    let rowCount = 2;

    function addRow() {
        const table = document.getElementById("stockTable");
        const tbody = table.getElementsByTagName("tbody")[0];

        const newRow = document.createElement("tr");

        const stockCell = document.createElement("td");
        const stockSelect = document.createElement("select");
        stockSelect.name = "stock" + rowCount;

        <?php foreach ($stocks as $stock) { ?>
            const stockOption = document.createElement("option");
            stockOption.value = "<?php echo $stock->nom_st; ?>";
            stockOption.textContent = "<?php echo $stock->nom_st; ?>";
            stockSelect.appendChild(stockOption);
        <?php } ?>

        stockCell.appendChild(stockSelect);

        const qteCell = document.createElement("td");
        const qteInput = document.createElement("input");
        qteInput.type = "text";
        qteInput.name = "qte" + rowCount;
        qteCell.appendChild(qteInput);

        rowCount++;

        newRow.appendChild(stockCell);
        newRow.appendChild(qteCell);
        tbody.appendChild(newRow);

        updateNumberOfStock();
    }

    function updateNumberOfStock() {
        const numberOfStockInput = document.getElementById("numberOfStocks");
        numberOfStockInput.value = rowCount - 1;
    }
</script>