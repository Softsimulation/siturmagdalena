<div class="col-md-6" ng-repeat="pregunta in seccion.preguntas">
                        <div class="form-group" ng-class="{ 'error': (form.$submitted || form.item@{{pregunta.id}}.$touched) && !form.item@{{pregunta.id}}.$valid}">
                            <label class="control-label" for="item@{{pregunta.id}}">@{{pregunta.idiomas[0].pregunta}}</label>
                            
                            <input ng-if="pregunta.tipo_campos_id==1" type="text"   class="form-control" id="item@{{pregunta.id}}" name="item@{{pregunta.id}}" ng-model="pregunta.respuesta" maxlength="@{{pregunta.max_length}}" ng-required="@{{pregunta.es_requerido}}" />
                            
                            <input ng-if="pregunta.tipo_campos_id==2" type="number" class="form-control" id="item@{{pregunta.id}}" name="item@{{pregunta.id}}" ng-model="pregunta.respuesta" min="@{{pregunta.valor_min}}" max="@{{pregunta.valor_max}}" ng-required="@{{pregunta.es_requerido}}" />
                            
                             <div ng-if="pregunta.tipo_campos_id==3" class="radio" ng-repeat="op in pregunta.opciones" >
                                 <label> <input type="radio" name="item@{{op.id}}" ng-model="pregunta.respuesta" ng-value="op.id" ng-required="!pregunta.respuesta"> @{{op.idiomas[0].nombre}} </label>
                            </div>
                            
                            <adm-dtp ng-if="pregunta.tipo_campos_id==4" options="optionFecha" ng-model="pregunta.respuesta" ng-required="pregunta.es_requerido" ></adm-dtp>
                            
                            <ui-select ng-if="pregunta.tipo_campos_id==5" name="item@{{pregunta.id}}" ng-model="pregunta.respuesta" ng-required="@{{pregunta.es_requerido}}" >
                                <ui-select-match > @{{$select.selected.idiomas[0].nombre}} </ui-select-match>
                                <ui-select-choices repeat="item.id as item in ( pregunta.opciones | filter: $select.search)">
                                    <small> @{{item.idiomas[0].nombre}} </small>
                                </ui-select-choices>
                            </ui-select>
                            
                            <ui-select ng-if="pregunta.tipo_campos_id==6" name="item@{{pregunta.id}}" multiple ng-model="pregunta.respuesta" ng-required="@{{pregunta.es_requerido}}">
                                <ui-select-match > @{{$item.idiomas[0].nombre}} </ui-select-match>
                                <ui-select-choices repeat="item.id as item in pregunta.opciones | filter:$select.search">
                                        <small> @{{item.idiomas[0].nombre}} </small>
                                </ui-select-choices>
                            </ui-select>
                            
                            <div ng-if="pregunta.tipo_campos_id==7" class="checkbox" ng-repeat="op in pregunta.opciones" >
                                <label><input type="checkbox" name="item@{{pregunta.id}}@{{$index}}" checklist-model="pregunta.respuesta" checklist-value="op.id" > @{{op.idiomas[0].nombre}} </label>
                            </div>
                            <span ng-show="(form.$submitted || form.item@{{pregunta.id}}.$touched)" >
                                <span ng-show="form.item@{{pregunta.id}}.$error.required">Campo requerido</span>
                                <span ng-show="form.item@{{pregunta.id}}.$error.min">El valor minimo es @{{pregunta.valor_min}}</span>
                                <span ng-show="form.item@{{pregunta.id}}.$error.max">El valor maximo es @{{pregunta.valor_max}}</span>
                                <span ng-show="form.item@{{pregunta.id}}.$error.number">Formato de numero invalido</span>
                                <span ng-show="form.item@{{pregunta.id}}.$error.maxlength">El numero maximo de caracteres es @{{pregunta.max_length}}</span>
                                <span ng-show="(pregunta.es_requerido && (pregunta.respuesta==null || pregunta.respuesta.length==0) && (pregunta.tipo_campos_id==4 || pregunta.tipo_campos_id==5 || pregunta.tipo_campos_id==6 || pregunta.tipo_campos_id==7))">Campo requerido</span>
                            </span>
                        </div>
                    </div>