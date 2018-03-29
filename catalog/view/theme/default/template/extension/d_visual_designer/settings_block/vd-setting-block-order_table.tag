<vd-setting-block-order_table>
<div class="form-group col-md-12"> 
   <label class="vd-checkbox col-md-6">
        <div class="col-md-3">{store.getLocal('blocks.order_table.name')}</div>
        <input type="hidden" name="name" value="0" />
        <div class="col-md-3"><input type="checkbox" name="name" class="switcher" checked={setting.edit.name} value="1" change={change} /></div>
        
    </label>
    <label class="vd-checkbox col-md-6">
        <div class="col-md-3">{store.getLocal('blocks.order_table.email')}</div>
        <input type="hidden" name="email" value="0" />
        <div class="col-md-3"><input type="checkbox" name="email" class="switcher" checked={setting.edit.email} value="1" change={change} /></div>
        
    </label>
    <label class="vd-checkbox col-md-6">
        <div class="col-md-3">{store.getLocal('blocks.order_table.payment_method')}</div>
        <input type="hidden" name="payment_method" value="0" />
        <div class="col-md-3"><input type="checkbox" name="payment_method" class="switcher" checked={setting.edit.payment_method} value="1" change={change} /></div>
        
    </label>
    <label class="vd-checkbox col-md-6">
        <div class="col-md-3">{store.getLocal('blocks.order_table.shipping_method')}</div>
        <input type="hidden" name="shipping_method" value="0" />
        <div class="col-md-3"><input type="checkbox" name="shipping_method" class="switcher" checked={setting.edit.shipping_method} value="1" change={change} /></div>
        
    </label>
    <label class="vd-checkbox col-md-6">
        <div class="col-md-3">{store.getLocal('blocks.order_table.payment_address_1')}</div>
        <input type="hidden" name="payment_address_1" value="0" />
        <div class="col-md-3"><input type="checkbox" name="payment_address_1" class="switcher" checked={setting.edit.payment_address_1} value="1" change={change} /></div>
        
    </label>
    <label class="vd-checkbox col-md-6">
    <div class="col-md-3">{store.getLocal('blocks.order_table.shipping_address_1')}</div>
        <input type="hidden" name="shipping_address_1" value="0" />
        <div class="col-md-3"><input type="checkbox" name="shipping_address_1" class="switcher" checked={setting.edit.shipping_address_1} value="1" change={change} /></div>

    </label>
   <label class="vd-checkbox col-md-6">
        <div class="col-md-3">{store.getLocal('blocks.order_table.date_added')}</div>
        <input type="hidden" name="date_added" value="0" />
        <div class="col-md-3"><input type="checkbox" name="date_added" class="switcher" checked={setting.edit.date_added} value="1" change={change} /></div>
    </label>
    <label class="vd-checkbox col-md-6">
        <div class="col-md-3">{store.getLocal('blocks.order_table.payment_country')}</div>
        <input type="hidden" name="payment_country" value="0" />
        <div class="col-md-3"><input type="checkbox" name="payment_country" class="switcher" checked={setting.edit.payment_country} value="1" change={change} /></div>
    </label>
    <label class="vd-checkbox col-md-6">
        <div class="col-md-3">{store.getLocal('blocks.order_table.payment_city')}</div>
        <input type="hidden" name="payment_city" value="0" />
        <div class="col-md-3"><input type="checkbox" name="payment_city" class="switcher" checked={setting.edit.payment_city} value="1" change={change} /></div>
    </label>
    <label class="vd-checkbox col-md-6">
        <div class="col-md-3">{store.getLocal('blocks.order_table.payment_postcode')}</div>
        <input type="hidden" name="payment_postcode" value="0" />
        <div class="col-md-3"><input type="checkbox" name="payment_postcode" class="switcher" checked={setting.edit.payment_postcode} value="1" change={change} /></div>
    </label>
    <label class="vd-checkbox col-md-6">
        <div class="col-md-3">{store.getLocal('blocks.order_table.shipping_country')}</div>
        <input type="hidden" name="shipping_city" value="0" />
        <div class="col-md-3"><input type="checkbox" name="shipping_city" class="switcher" checked={setting.edit.shipping_country} value="1" change={change} /></div>
    </label>
    <label class="vd-checkbox col-md-6">
        <div class="col-md-3">{store.getLocal('blocks.order_table.shipping_city')}</div>
        <input type="hidden" name="shipping_city" value="0" />
        <div class="col-md-3"><input type="checkbox" name="shipping_city" class="switcher" checked={setting.edit.shipping_city} value="1" change={change} /></div>
    </label>
    <label class="vd-checkbox col-md-6">
        <div class="col-md-3">{store.getLocal('blocks.order_table.shipping_postcode')}</div>
        <input type="hidden" name="shipping_postcode" value="0" />
        <div class="col-md-3"><input type="checkbox" name="shipping_postcode" class="switcher" checked={setting.edit.shipping_postcode} value="1" change={change} /></div>
    </label>
</div>
<script>
    this.top = this.parent ? this.parent.top : this
    this.level = this.parent.level
    this.mixin({store:d_visual_designer})
    this.setting = this.opts.block.setting
    this.on('update', function(){
        this.setting = this.opts.block.setting
    })
    change(name, value){
        this.setting.global[name] = value
        this.setting.user[name] = value
        this.store.dispatch('block/setting/fastUpdate', {designer_id: this.parent.designer_id, block_id: this.opts.block.id, setting: this.setting})
        this.update()
    }
       this.on('mount', function(){
        $(".switcher[type='checkbox']", this.root).bootstrapSwitch({
            'onColor': 'success',
            'onText': this.store.getLocal('blocks.image.text_yes'),
            'offText': this.store.getLocal('blocks.image.text_no')
        });
        $(".switcher[type='checkbox']", this.root).on('switchChange.bootstrapSwitch', function(e, state) {
            this.setting.global[e.target.name] = state
            this.store.dispatch('block/setting/fastUpdate', {designer_id: this.parent.designer_id, block_id: this.opts.block.id, setting: this.setting})
        }.bind(this));
    })
</script>
</vd-setting-block-order_table>