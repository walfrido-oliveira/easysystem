<div class="modal fade" id="searchClient" tabindex="-1" role="dialog" aria-labelledby="searchClientLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="searchClientLabel">Buscar Cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Nome.:</label>
            <input type="text" class="form-control" id="searchClientValue">
          </div>
        </form>
        <div class="modal-table">
            <table class="table table-bordered table-hover" id="client_results">
                <thead>
                    <tr class="modal-datble-head">
                        <th class="column1">#</th>
                        <th class="column2">Razão Social</th>
                        <th class="column2">CNPJ</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
