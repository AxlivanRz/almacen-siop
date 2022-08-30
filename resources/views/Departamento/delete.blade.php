<!-- Modal -->
<div class="modal fade" id="departamentoDelete{{$departamento->id_departamento}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="departamentoDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" style="width: 450px">
        <div class="modal-header bg-white border-0 " style="height: 50px">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="content" style="align-self: center">
                <div class="modal-body bg-white">
                        <div class = "row">
                            <div class="col-md-12">
                                <div class="mx-auto d-block" style="text-align: center">
                                 <i class="fas fa-exclamation-circle fa-9x" style = "color: red;"></i>
                                </div>
                            </div>
                        </div>
                            <br>
                         <h5 style="color: dark; text-align: center;">¿Está seguro de eliminar {{$departamento->nombre_departamento}}?</h5>                    
                </div>
            </div>
            <div class="d-flex justify-content-center align-items-center " style="height: 85px">
                <div class="modal-footer bg-white border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cerrar</button>
                    <form action="{{route('departamento.destroy',$departamento->id_departamento)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-success">Sí</button>
                      </form>
                    
                </div>
            </div>
      </div>
    </div>
</div>