$(document).ready(function() {
    $('.parent-checkbox').on('change', function() {
        const isChecked = $(this).is(':checked');
        $(this).closest('.form-group').find(`.child-checkbox`).prop('checked', isChecked);
    });
    $('.child-checkbox').on('change',function () {
        updateParentCheckBoxes();
    })
    function updateParentCheckBoxes() {
        $('.parent-checkbox').each(function () {
            var isChecked = true;
            $(this).closest('.form-group').find(`.child-checkbox`).each(function () {
                if ( !$(this).is(':checked')) {
                    isChecked = false;
                }
            })
            $(this).prop('checked', isChecked);
        })
    }
    updateParentCheckBoxes();
});
