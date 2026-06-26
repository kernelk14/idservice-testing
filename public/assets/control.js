document.querySelectorAll('.row-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const isAnyChecked = document.querySelectorAll('.row-checkbox:checked').length > 0;
        document.getElementById('actionBtn').style.display = isAnyChecked ? 'block' : 'none';
    });
});
