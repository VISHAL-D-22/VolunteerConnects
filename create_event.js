document.querySelector('.btn-light').addEventListener('click', function() {
        const container = document.getElementById('role-container');
        const newRow = document.createElement('div');
        newRow.className = 'row g-2 mb-3 align-items-end role-row';
        newRow.innerHTML = `
            <div class="col-md-7">
                <input type="text" name="role_name[]" class="form-control" placeholder="e.g. Logistics">
            </div>
            <div class="col-md-3">
                <input type="number" name="required_count[]" class="form-control" min="1">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-outline-danger w-100" onclick="this.parentElement.parentElement.remove()">Remove</button>
            </div>
        `;
        container.appendChild(newRow);
    });