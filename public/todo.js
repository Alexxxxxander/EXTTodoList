Ext.onReady(function() {
    var store = new Ext.data.JsonStore({
        url: 'src/ajax_todo.php',
        fields: ['id', 'task', 'is_completed'],
        autoLoad: true,
        method: 'POST',
        baseParams: { action: 'getTasks' },
        listeners: {
            load: function(store, records, options) {
                console.log("Data loaded:", records);
            },
            loadexception: function(proxy, options, response, error) {
                console.log("Ошибка при загрузке данных:", response.responseText);
                if(JSON.parse(response.responseText)["error"] === "Unauthorized"){
                    window.location = 'login.html';
                }
            }
        }
    });

    var grid = new Ext.grid.GridPanel({
        store: store,
        columns: [
            new Ext.grid.CheckboxSelectionModel(), // Добавляем выбор строк с чекбоксами
            { header: 'Task', dataIndex: 'task', flex: 1 },
            {
                header: 'Complete',
                xtype: 'gridcolumn',
                dataIndex: 'is_completed',
                renderer: function(value, metadata, record) {
                    var checked = value ? 'checked' : '';
                    return `<input type="checkbox" ${checked} onclick="toggleComplete(${record.get('id')}, this.checked)">`;
                },
                listeners: {
                    checkchange: function(checkColumn, rowIndex, checked) {
                        var record = store.getAt(rowIndex);
                        Ext.Ajax.request({
                            url: 'src/ajax_todo.php',
                            params: { action: 'completeTask', taskId: record.get('id') },
                            success: function() {
                                store.reload(); // Перезагружаем хранилище для обновления
                            }
                        });
                    }
                }
            }
        ],
        selModel: new Ext.grid.CheckboxSelectionModel(), // Объект для выбора строк
        tbar: [
            {
                xtype: 'textfield',
                id: 'newTask',
                emptyText: 'New Task'
            },
            {
                text: 'Add Task',
                handler: function() {
                    var task = Ext.getCmp('newTask').getValue();
                    Ext.Ajax.request({
                        url: 'src/ajax_todo.php',
                        params: { action: 'addTask', task: task },
                        success: function() {
                            store.reload();
                        }
                    });
                }
            },
            {
                text: 'Delete Selected',
                handler: function() {
                    var selection = grid.getSelectionModel().getSelections();
                    if (selection.length > 0) {
                        var taskIds = [];
                        Ext.each(selection, function(record) {
                            taskIds.push(record.get('id'));
                        });
                        Ext.Ajax.request({
                            url: 'src/ajax_todo.php',
                            params: { action: 'deleteTasks', taskIds: taskIds.join(',') },
                            success: function() {
                                store.reload(); // Перезагружаем хранилище после удаления
                            }
                        });
                    } else {
                        alert("No tasks selected for deletion.");
                    }
                }
            }
        ],
        buttons: [
            {
                text: 'Logout',
                handler: function() {
                    Ext.Ajax.request({
                        url: 'src/auth.php',
                        params: { action: 'logout' },
                        success: function() {
                            window.location = 'login.html';
                        },
                        failure: function() {
                            alert('Logout failed');
                        }
                    });
                }
            }
        ],
        renderTo: 'todo-list-container',
        height: 400, // Установка высоты для отображения
        width: 600, // Установка ширины для отображения
        title: 'Todo List', // Заголовок для Grid
        frame: true // Добавление рамки
    });
    window.toggleComplete = function(taskId, isChecked) {
        Ext.Ajax.request({
            url: 'src/ajax_todo.php',
            params: {
                action: 'updateTaskStatus',
                taskId: taskId,
                is_completed: isChecked ? 1 : 0
            },
            success: function() {
                store.reload();
            }
        });
    };
});
