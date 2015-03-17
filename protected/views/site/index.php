<?php
/* @var $this SiteController */


//add js & css
Yii::app()->clientScript->registerScriptFile('http://dev.sencha.com/extjs/5.0.0/examples/shared/include-ext.js'); 

$this->pageTitle=Yii::app()->name;
?>

<h1>Управление хостами</h1>
 

<div id="content-ext"></div>

<script type="text/javascript">
Ext.require(['Ext.data.*', 'Ext.grid.*']);

Ext.define('ServerHost', {
    extend: 'Ext.data.Model',
    idProperty: 'Id',
    fields: [{
        name: 'Id', type: 'int', useNull: true
    }, {
        name:'port', type: 'int', defaultValue: 80
    } , { 
        name: 'ip' ,  defaultValue: '*'
    }, { 
        name: 'ServerAdmin' ,   defaultValue: '<?php echo Yii::app()->params['adminEmail'];?>'
    }, 'fileConf',  'ServerName', 'ServerAlias', 'DocumentRoot', 'ErrorLog', 'CustomLog'],
    validations: [{
        type: 'email',  field: 'ServerAdmin' 
    }, {
        type: 'length',
        field: 'DocumentRoot',
        min: 1
    }, {
        type: 'base',   field: 'ServerName', matcher :/^(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)/        
    }]
});  

Ext.onReady(function(){ 
  
     var store = Ext.create('Ext.data.Store', {
        model: 'ServerHost',
        autoLoad: true,
        autoSync: true,
        proxy: {
            type: 'ajax',
            api: {
                read: 'index.php?r=api/hosts',
                create: 'index.php?r=api/addhost',
                update: 'index.php?r=api/updatehost',
                destroy: 'index.php?r=api/removehost'
            },
            reader: {
                type: 'json',
                successProperty: 'success',
                root: 'data',
                messageProperty: 'message'
            },
            writer: {
                type: 'json',
                writeAllFields: false,
                root: 'data',
                transform: {
                    fn: function(data, request) { 
                        return {ServerHost:data};
                    },
                    scope: this
                }
            },
            listeners: {
                exception: function(proxy, response, operation){
                    Ext.MessageBox.show({
                        title: 'Ошибка',
                        msg: operation.getError(),
                        icon: Ext.MessageBox.ERROR,
                        buttons: Ext.Msg.OK
                    });
                    console.log(operation.getError());
                }
            }
        },
        listeners: {
            write: function(proxy, operation){
                if(operation.action === 'create') {
                    store.reload();
                }
                console.log(operation.action, operation.getResultSet().message);
            }
        }
    });
    
    Ext.grid.RowEditor.prototype.cancelBtnText = "Отменить";
    Ext.grid.RowEditor.prototype.saveBtnText = "Сохранить";
     var rowEditing = Ext.create('Ext.grid.plugin.RowEditing', {
        listeners: {
            cancelEdit: function(rowEditing, context) { 
                if (context.record.phantom) {
                    store.remove(context.record);
                }
            }
        }
    });
    
     var grid = Ext.create('Ext.grid.Panel', {
        renderTo: 'content-ext',
        plugins: [rowEditing],
        width: '100%', 
        frame: true, 
        store: store, 
        columns: [{
            text: 'ID',
            width: 50,
            sortable: true,
            dataIndex: 'Id',
            renderer: function(v, meta, rec) {
                return rec.phantom ? '' : v;
            }
        }, {
            text: 'Порт',
            width: 60,
            sortable: true,
            dataIndex: 'port',
            field: {
                xtype: 'textfield'
            }
        }, {
            text: 'IP',
            flex: 1,
            sortable: true,
            dataIndex: 'ip',
            field: {
                xtype: 'textfield'
            }
        },{
            header: 'Email Админа',
            width: 120,
            sortable: true,
            dataIndex: 'ServerAdmin',
            field: {
                xtype: 'textfield'
            }
        },{
            header: 'Имя сайта',
            width: 120,
            sortable: true,
            dataIndex: 'ServerName',
            field: {
                xtype: 'textfield'
            }
        },{
            header: 'Псевдоним сайта',
            width: 120,
            sortable: true,
            dataIndex: 'ServerAlias',
            field: {
                xtype: 'textfield'
            }
        },{
            header: 'Папка сайта',
            flex: 1,
            sortable: true,
            dataIndex: 'DocumentRoot',
            field: {
                xtype: 'textfield'
            }
        },{
            header: 'Путь к логу ошибок',
            flex: 1,
            sortable: true,
            dataIndex: 'ErrorLog',
            field: {
                xtype: 'textfield'
            }
        }],    
        dockedItems: [{
            xtype: 'toolbar',
            items: [{
                text: 'Добавить',
               // iconCls: 'icon-add',
                handler: function(){ 
                     store.insert(0, new ServerHost());
                     rowEditing.startEdit(0, 0);
                }
            }, '-', {
                itemId: 'delete',
                text: 'Удалить',
               // iconCls: 'icon-delete',
                disabled: true,
                handler: function(){
                    var selection = grid.getView().getSelectionModel().getSelection()[0];
                    if (selection) {
                        store.remove(selection);
                    }
                }
            }]
        }]
    });
    
    grid.getSelectionModel().on('selectionchange', function(selModel, selections){
        grid.down('#delete').setDisabled(selections.length === 0);
    });
});
</script>
    