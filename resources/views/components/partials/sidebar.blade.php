<div class="flex-shrink-0 p-3 bg-white sidebar">
    <form action="" method="get">
        <a class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none border-bottom">
            <svg class="bi me-2" width="30" height="24">
                <use xlink:href="#bootstrap"></use>
            </svg>
            <span class="fs-5 fw-semibold">Sidebar</span>
        </a>
        <ul class="list-unstyled ps-0">
            <li class="mb-1">
                Sorted By:
                <select name="order" id="order" class="btn btn-toggle align-items-start rounded collapsed">
                    <option value="name">Name</option>
                    <option value="release_date">Release Date</option>
                    <option value="cost">Cost</option>
                </select>
            </li>
            <li class="mb-1">
                Product Type:
                <select name="productType" id="productType" class="btn btn-toggle align-items-start rounded collapsed">
                    <option value="all" selected>All</option>
                    @foreach($productTypes as $values)
                        <option value="{{ $values->id }}">{{ $values->type_name }}</option>
                    @endforeach
                </select>
            </li>
            <li class="mb-1">
                <input type="number" name="minCost" id="minCost" class="sidebar-input" placeholder="Min Cost">
                <input type="number" name="maxCost" id="maxCost" class="sidebar-input" placeholder="Max Cost">
            </li>
        </ul>
        <button type="submit" class="btn btn-light">Submit</button>
    </form>
</div>
