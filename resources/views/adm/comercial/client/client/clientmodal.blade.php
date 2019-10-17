<div class="modal fade" id="searchClient" tabindex="-1" role="dialog" aria-labelledby="searchClientLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="searchClientLabel">Buscar CNPJ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">CNPJ:</label>
                            <input type="text" class="form-control" id="cnpjModalValue" name="cnpjModalValue" data-mask="99.999.999/9999-99">
                        </div>
                    </form>
                    <div class="alert alert-danger" style="display: none;" id="alert_cnpj_modal">
                    </div>
                </div>
                <div class="col-md-12">
                    <fieldset id='fieldset_client_modal'>
                        <dl class="row">
                            <dt class="col-sm-4">Razão Social</dt>
                            <dd class="col-sm-8" id="razao_social_modal"></dd>
                            <dt class="col-sm-4">Nome Faltasia</dt>
                            <dd class="col-sm-8" id="nome_fantasia_modal"></dd>
                            <dt class="col-sm-4">Telefone</dt>
                            <dd class="col-sm-8" id="phone_modal"></dd>
                            <dt class="col-sm-4">Telefone 2</dt>
                            <dd class="col-sm-8" id="phone_2_modal"></dd>
                            <dt class="col-sm-4">Esdereço</dt>
                            <dd class="col-sm-8" id="adress_modal"></dd>
                            <dt class="col-sm-4">Bairro</dt>
                            <dd class="col-sm-8" id="district_modal"></dd>
                            <dt class="col-sm-4">Cidade</dt>
                            <dd class="col-sm-8" id="city_modal"></dd>
                            <dt class="col-sm-4">Estado</dt>
                            <dd class="col-sm-8" id="state_modal"></dd>
                            <dt class="col-sm-4">Número</dt>
                            <dd class="col-sm-8" id="number_modal"></dd>
                            <dt class="col-sm-4">CEP</dt>
                            <dd class="col-sm-8" id="cep_modal"></dd>
                        </dl>
                    </fieldset>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="close_cnpj_modal" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" id="import_cnpj_modal" disabled>Importar</button>
        <button type="button" class="btn btn-primary" id="search_cnpj_modal">Buscar</button>
      </div>
    </div>
  </div>
</div>
