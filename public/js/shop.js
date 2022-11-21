var
    $form = $("#our-form"),
    $allCheckboxes = $("input:checkbox", $form),
    $sumOut = $("#checked-sum"),
    $countOut = $("#checked-count");

function totalPrice() {
    var
        sum = Number(document.getElementById('product-price').textContent),
        count = 0;
    $allCheckboxes.each(function(index, el) {
        var
            $el = $(el),
            val;
        if ($el.is(":checked")) {
            count++;
            val = parseFloat($el.val());
            if (!isNaN(val)) {
                sum += val;
            }
        }
    });
    $sumOut.text(sum);
    $countOut.text(count);
}

$allCheckboxes.change(totalPrice);
document.addEventListener('DOMContentLoaded', totalPrice);

function confirmation() {
    return confirm('Are you sure you want to do this?');
}
