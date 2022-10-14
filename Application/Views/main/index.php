<div class="row">
    <div class="col-4">
        <H1>Main page</H1>
    </div>
    <div class="col-8 align-items-center">
        <div class="row justify-content-end">
            <div class="col-4">
                <a href="/user/create">
                    <button type="button" class="btn btn-primary">Add new user</button type>
                </a>
            </div>
        </div>
    </div>
</div>

<table>
    <thead>
    <tr>
        <th>Id</th>
        <th>Email</th>
        <th>Name</th>
        <th>Gender</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    </thead>
<!--    <tbody class="data-list">-->
<!---->
<!--    </tbody>-->
    <tbody>
    <?php foreach ($users as $row): ?>
        <tr>
            <td><?php echo $row->id; ?></td>
            <td><?php echo $row->email; ?></td>
            <td><?php echo $row->name; ?></td>
            <td><?php echo $row->gender; ?></td>
            <td><?php echo $row->status; ?></td>
            <td><?php echo '<a href="/user/update/' . $row->id . '"><button type="button" class="btn btn-success">Update</button></a>'; ?>
                <?php echo '<a href="/user/delete/' . $row->id . '" onclick="return confirmation()"><button type="button" class="btn btn-danger">Delete</button></a>'; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
