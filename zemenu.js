window.menu = {};
menu.delect = function(type){
    var result = window.confirm("你确定要删除这个菜单吗？注意：该菜单下如果有子级菜单，删除后子级菜单也会被清空！");
    if (!result) {return;}
    type.closest('.zemenu-item').remove();
    menu.sort();
}
menu.dialog = function(type){
    if(!document.querySelector('#menudialog')){
    let name='';
    let a='';
    let icon='';
    let typex='';
    let blank='0';
    if(type){
    let li=type.closest('.zemenu-item');
    let id=li.getAttribute('id');
        name=li.querySelector('a').getAttribute('data-name');
        a=li.querySelector('a').getAttribute('data-a');
        icon=li.querySelector('a').getAttribute('data-icon');
        blank=li.querySelector('a').getAttribute('data-blank');
        typex="'"+id+"'";
    }
    
    var blank0='selected';
    var blank1='';
    if(blank=='1'){
     blank0='';
     blank1='selected';
    }
    
    
    
    var tip=`<div id="menudialog" class="wmd-prompt-dialog" style="top:30%"><button onclick="menu.dialogclose()" class="cloase"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
</svg>
</button>
    <h3>短代码 - 按钮样式的链接</h3>
    <label for="name">名字</label>
    <input id="name" type="text" value="${name}" class="w-100">
    <label for="a">链接</label>
    <input id="a" type="text" value="${a}" class="w-100">
    <label for="icon">图标参数</label>
    <input id="icon" type="text" value="${icon}" class="w-100">
    <p class="form-group"><label for="blank" >新窗口打开：</label><select id="blank" name="blank"><option value="0" ${blank0}>否</option><option value="1" ${blank1}>是</option></select></p>
    <button onclick="menu.dialogok(${typex})" type="button" class="w-100 btn btn-s primary">保存</button>
    </div>`;
document.body.insertAdjacentHTML('beforeend', tip);
}
}

menu.dialogok = function(type){
    
        let name = $('#menudialog #name').val();
        let a = $('#menudialog #a').val();
        let icon = $('#menudialog #icon').val();
        let blank=$("#menudialog #blank option:selected").val();
        if(!name||!a){
            alert('名字和链接不能为空，请重新填写！');
            return;
        }
        
        
        let ahtml=`<a data-name="${name}" data-a="${a}" data-icon="${icon}" href="${a}" title="${name}" data-blank="${blank}" target="_blank">${name}</a>`;
        let html=`
        <div class="zemenu-item" :id="$id('text-input')" x-sort:item><div class="flex-between">${ahtml}<div><button onclick="menu.dialog(this)">编辑</button><button onclick="menu.delect(this)">删除</button></div></div><div x-sort="menu.sort" class="son" x-sort x-sort:group="zemenu"></div></div>`;
if(type){ console.log('修改');
       document.querySelector('#'+type+' a').outerHTML=ahtml;
}else{
document.querySelector('.okmenu').insertAdjacentHTML('beforeend', html);
    }
menu.dialogclose();
menu.sort();
}

menu.dialogclose = function(){
     if(document.querySelector('#menudialog')){
   document.querySelector('#menudialog').remove();
     }
}


menu.sort = function(){
    let mids=document.querySelectorAll('#zemenu>.zemenu-item');
    let ids=[];
    Array.from(mids).forEach(li => {  
        let name=li.querySelector('a').getAttribute('data-name');
        let a=li.querySelector('a').getAttribute('data-a');
        let icon=li.querySelector('a').getAttribute('data-icon');
        let blank=li.querySelector('a').getAttribute('data-blank');
        
        
        
        let xli=li.querySelectorAll('.zemenu-item');
        let son=[];
        Array.from(xli).forEach(li => {
        let name=li.querySelector('a').getAttribute('data-name');
        let a=li.querySelector('a').getAttribute('data-a');
        let icon=li.querySelector('a').getAttribute('data-icon');
        let blank=li.querySelector('a').getAttribute('data-blank');
        var xarray={
            'name':name,
            'a':a,
            'icon':icon,
            'blank':blank,
            };
        son.push(xarray);
            
        });
        
        var array={
            'name':name,
            'a':a,
            'icon':icon,
            'blank':blank,
            'son':son,
            };
            
        ids.push(array);
        
        });

var url = '?panel=ZeMenu%2Fpanel.php&add=menu';
     fetch(url, { method: "POST",body:JSON.stringify(ids) }) .then(response => response.json()).then(data => {
            if(data.status==1){
            }else{
                main.notice('error',data.info);
            }
        });
}