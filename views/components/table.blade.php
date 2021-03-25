<div class="antialiased">
    <style>

        [type="checkbox"] {
            box-sizing: border-box;
            padding: 0;
        }

        .form-checkbox {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
            display: inline-block;
            vertical-align: middle;
            background-origin: border-box;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            flex-shrink: 0;
            color: currentColor;
            background-color: #fff;
            border-color: #e2e8f0;
            border-width: 1px;
            border-radius: 0.25rem;
            height: 1.2em;
            width: 1.2em;
        }

        .form-checkbox:checked {
            background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M5.707 7.293a1 1 0 0 0-1.414 1.414l2 2a1 1 0 0 0 1.414 0l4-4a1 1 0 0 0-1.414-1.414L7 8.586 5.707 7.293z'/%3e%3c/svg%3e");
            border-color: transparent;
            background-color: currentColor;
            background-size: 100% 100%;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>

    <div class="py-6 mx-auto text-sm" x-data="datatables()" x-cloak>
        @include("paksuco-table::components.filters")
        <div class="relative overflow-x-auto bg-white border rounded shadow-sm">
            <table class="relative w-full bg-white border-collapse table-auto">
                <thead>
                    @include("paksuco-table::components.headers")
                </thead>
                <tbody>
                    @foreach($rows as $row)
                    @include("paksuco-table::components.rows", $row)
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($settings->pageable)
        {{$rows->links()}}
        @endif
    </div>

    <script>
        function datatables() {
			return {
				selectedRows: [],
				toggleColumn(key, $event) {
                    let columns = document.querySelectorAll('.' + key);
                    let checked = $event.srcElement.checked;
					if (checked) {
						columns.forEach(column => {
							column.classList.remove('hidden');
						});
					} else {
						columns.forEach(column => {
							column.classList.add('hidden');
						});
					}
				},
				getRowDetail($event, id) {
					let rows = this.selectedRows;

					if (rows.includes(id)) {
						let index = rows.indexOf(id);
						rows.splice(index, 1);
					} else {
						rows.push(id);
					}
				},
				selectAllCheckbox($event) {
					let columns = document.querySelectorAll('.rowCheckbox');

					this.selectedRows = [];

					if ($event.target.checked == true) {
						columns.forEach(column => {
							column.checked = true
							this.selectedRows.push(parseInt(column.name))
						});
					} else {
						columns.forEach(column => {
							column.checked = false
						});
						this.selectedRows = [];
					}
				}
			}
		}
    </script>
</div>
