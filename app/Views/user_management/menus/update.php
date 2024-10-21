<!-- Edit Modal -->
<div class="modal fade" id="modal-update" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit - <?= $sub_header ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-edit" class="form-horizontal">
                    <input type="hidden" id="menu_id">
                    
                    <div class="mb-3 row">
                        <label for="parent_id" class="col-sm-2 col-form-label">Parent</label>
                        <div class="col-sm-12">
                            <select name="parent_id" id="parent_id" class="form-control">
                                <option value="0">ROOT</option>
                            </select>
                            <div class="form-text text-danger">
                                <i class="fas fa-exclamation-triangle"></i> Menu hanya mendukung maksimal kedalaman 2.
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <label for="active" class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-12">
                            <select class="form-control" id="active" name="active">
                                <option value="1">Active</option>
                                <option value="0">Non Active</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Icon</label>
                        <div class="col-sm-12">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fab fa-font-awesome-flag"></i></span>
                                <input type="text" name="icon" class="icon-picker form-control" placeholder="Icon from FontAwesome" autocomplete="off">
                            </div>
                            <div class="form-text">
                                <i class="fa fa-info-circle text-info"></i> More Icon
                                <a href="http://fontawesome.io/icons" target="_blank">http://fontawesome.io/icons</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <label for="title" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-12">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                <input type="text" name="title" id="title" class="form-control" placeholder="Name for menu" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <label for="route" class="col-sm-2 col-form-label">Route</label>
                        <div class="col-sm-12">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-link"></i></span>
                                <input type="text" name="route" id="route" class="form-control" placeholder="link menu" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <label for="groups_menu" class="col-sm-2 col-form-label">Role</label>
                        <div class="col-sm-12">
                            <select name="groups_menu[]" id="groups_menu" class="form-control parent" multiple="multiple">
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn bg-gradient-primary" id="btn-update">Save</button>
            </div>
        </div>
    </div>
</div>
