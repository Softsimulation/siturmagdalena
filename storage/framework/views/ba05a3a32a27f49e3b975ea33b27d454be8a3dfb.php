<?php $__env->startSection('title','Encuesta dinamica'); ?>
<?php $__env->startSection('TitleSection', $encuesta->idiomas[0]->nombre); ?>
<?php $__env->startSection('app','ng-app="appEncuestaDinamica"'); ?>
<?php $__env->startSection('controller','ng-controller="EstadisticasrEncuestasCtrl"'); ?>

<?php $__env->startSection('content'); ?>

<div>
   <a class="btn btn-link btn-primary" href="/encuesta/listado" >Volver al listado</a>
    
    <div class="row" >
       <div class="col-md-9">
            
            <div class="row" style="margin-bottom:15px" >
                <div class="col-md-7" >
                    <div class="form-group" >
                        <select class="form-control" ng-model="selectPregunta" ng-change="changePregunta()"  >
                            <option value="" selected disabled >Selecione una pregunta para cargar los resultados</option>
                            <?php echo e($index = 1); ?>

                            <?php foreach($encuesta->secciones as $secccion): ?>
                                <option value=""  disabled >Seccion <?php echo e($index++); ?></option>
                                <?php foreach($secccion->preguntas as $pregunta): ?>
                                    <option value="<?php echo e($pregunta->id); ?>"><?php echo e($pregunta->idiomas[0]->pregunta); ?></option>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>   
                <div class="col-md-3" >
                    <div class="form-group" >
                        <select class="form-control" ng-model="tipoGrafica" >
                            <option value="bar" >Barras</option>
                            <option value="line">Área</option>
                        </select>
                    </div>
                </div>  
                <div class="col-md-2" >
                    <div class="form-group" >
                        <button class="btn btn-success" ng-click="descargarGrafica()" ng-disabled="!(data && data.length>0)" >
                            Descargar
                        </button>
                    </div>
                </div>  
            </div>
            
            <div class="row" style="margin-bottom:15px"  >
                <div class="col-md-12 text-center" >
                    <img src="/Content/icons/estadisticas/estadisticas.png" ng-if="!data || data.length==0" style="width: 220px;margin-left: 25%;margin-top: 50px;" >
                    <canvas id="base" class="chart-base" chart-type="tipoGrafica"
                      chart-data="data" chart-labels="labels" chart-series="series" chart-options="options" chart-colors="colores">
                    </canvas>
                </div>
             </div>  
             <div class="row" style="margin-bottom:15px"  >
                <div class="col-md-12" >
                    <table class="table table-striped" ng-show="data.length>0" >
                        <thead>
                          <tr>
                            <th></th>
                            <th ng-if="!isTablaContingencia" >Total</th>
                            <th ng-if="isTablaContingencia" ng-repeat="item in labels" class="text-center" >{{item}}</th>
                          </tr>
                        </thead>
                        <tbody ng-if="!isTablaContingencia" >
                          <tr  ng-repeat="label in labels" >
                            <td>{{label}}</td>
                            <td class="text-center" >{{data[$index]}}</td>
                          </tr>
                        </tbody>
                        <tbody  ng-if="isTablaContingencia">
                          <tr ng-repeat="datos in data track by $index" >
                            <td>{{series[$index]}}</td>
                            <td ng-repeat="d in datos track by $index" class="text-center" >{{d}}</td>
                          </tr>
                        </tbody>
                    </table>
                    
                </div>
            </div>
    
       </div>
       <div class="col-md-3" >
           
            <p><?php echo e($encuesta->idiomas[0]->descripcion); ?></p>
            
            <canvas id="polar-area" class="chart chart-polar-area" width="400" height="400"
              chart-data="[<?php echo e($terminadas); ?>,<?php echo e($noTerminadas); ?>]" chart-labels="['Terminadas','No terminadas']" 
              chart-options="{ legend: { display: true, position: 'bottom' }, title: { display: true, text: 'Encuestas' } }" >
            </canvas> 
            
            <ul class="list-group"> 
              <li class="list-group-item d-flex justify-content-between align-items-center" >
               Terminadas <span class="badge badge-pill"><?php echo e($terminadas); ?></span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center" >
                No terminadas <span class="badge badge-pill"><?php echo e($noTerminadas); ?></span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                Total <span class="badge badge-pill"><?php echo e($terminadas+$noTerminadas); ?></span>
              </li>
            </ul>
            
        </div>
    </div>
    
</div>
   
<style type="text/css">
       .list-group-item { cursor: default; }
       #openModalOrdenPreguntas .list-group-item { cursor: move; }
       .btn-agregar{
            margin-left: 10px;
            font-size: 1.1em;
            padding: 5px 11px;
            background: #5bb85b;
            border: none;
            border-radius: 35px;
            color: white;
            font-weight: bold;
       }
       .btn-agregar:focus { outline: none; }
       .list-group-item>.badge { background: red; }
       #openModalOrdenPreguntas .list-group-item>.badge { background: black; }
       .center{ text-align:center; }
    </style>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
    <script src="<?php echo e(asset('/js/plugins/Chart.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/plugins/angular-chart.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/plugins/angular-dragdrop.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/encuestas/dinamica/serviAdmin.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/encuestas/dinamica/appAdmin.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout._AdminLayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>