<vd-block-order_table>
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <td class="text-left" ><b>{store.getLocal('blocks.order_table.order_details')}</b></td>
                <td class="text-left" ><b>{store.getLocal('blocks.order_table.payment_details')}</b></td>
                <td class="text-left" ><b>{store.getLocal('blocks.order_table.shipping_details')}</b></td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="text-left" style="width: 50%;">
                    <b>{store.getLocal('blocks.order_table.order_id')} : </b>{opts.block.setting.user.order_id}<br />
                    <div if={opts.block.setting.user.name}>
                        <b>{store.getLocal('blocks.order_table.name')} : </b>{opts.block.setting.user.name}<br />
                    </div>            
                    <div if={opts.block.setting.user.email}>
                        <b >{store.getLocal('blocks.order_table.email')} :: </b>{opts.block.setting.user.email}<br />
                    </div>     
                    <div>
                        <b>{store.getLocal('blocks.order_table.date_added')} : </b>{opts.block.setting.user.date_added}<br />
                    </div>                                   
                </td>
                <td class="text-left">
                    <div if={opts.block.setting.user.payment_method}>
                        <b >{store.getLocal('blocks.order_table.payment_method')} : </b>{opts.block.setting.user.payment_method}<br />
                    </div>    
                    <div if={opts.block.setting.user.payment_address_1}>
                        <b >{store.getLocal('blocks.order_table.payment_address_1')} : </b>{opts.block.setting.user.payment_address_1}<br />
                    </div>   
                    <div if={opts.block.setting.user.payment_country}>
                        <b >{store.getLocal('blocks.order_table.payment_country')} : </b>{opts.block.setting.user.payment_country}<br />
                    </div>   
                    <div if={opts.block.setting.user.payment_city}>
                        <b >{store.getLocal('blocks.order_table.payment_city')} : </b>{opts.block.setting.user.payment_city}<br />
                    </div>   
                    <div if={opts.block.setting.user.payment_postcode}>
                        <b >{store.getLocal('blocks.order_table.payment_postcode')} : </b>{opts.block.setting.user.payment_postcode}<br />
                    </div>
                </td>
                <td class="text-left">
                    <div if={opts.block.setting.user.shipping_method}>
                        <b >{store.getLocal('blocks.order_table.shipping_method')} : </b>{opts.block.setting.user.shipping_method}<br />
                    </div>  
                    <div if={opts.block.setting.user.shipping_address_1}>
                        <b >{store.getLocal('blocks.order_table.shipping_address_1')} : </b>{opts.block.setting.user.shipping_address_1}<br />
                    </div>  
                    <div if={opts.block.setting.user.shipping_country}>
                        <b >{store.getLocal('blocks.order_table.shipping_country')} : </b>{opts.block.setting.user.shipping_country}<br />
                    </div>  
                    <div if={opts.block.setting.user.shipping_city}>
                        <b >{store.getLocal('blocks.order_table.shipping_city')} : </b>{opts.block.setting.user.shipping_city}<br />
                    </div>  
                    <div if={opts.block.setting.user.shipping_postcode}>
                        <b >{store.getLocal('blocks.order_table.shipping_postcode')} : </b>{opts.block.setting.user.shipping_postcode}<br />
                    </div>  
                </td>
            </tr>
            </tbody>
        <table>
        <table class="table table-bordered">
            <thead>
                <tr>
                <td class="text-left"><b>{store.getLocal('blocks.order_table.product')}</b></td>
                <td class="text-left"><b>{store.getLocal('blocks.order_table.model')}</b></td>
                <td class="text-right"><b>{store.getLocal('blocks.order_table.quantity')}</b></td>
                <td class="text-right"><b>{store.getLocal('blocks.order_table.price')}</b></td>
                <td class="text-right"><b>{store.getLocal('blocks.order_table.total')}</b></td>
                </tr>
            </thead>
        <tbody id="cart">
        <tr each={ product in opts.block.setting.user.order_products }>
            <td><a href=""><img src="{product.image}"/> {product.name} </a>
                <small each={ option in product.option }> {option.name} : {option.value}</small><br />
                    </td>
                    <td>{product.model}</td>
                    <td>{product.quantity}</td>
                    <td>{product.price}</td>
                    <td>{product.total}</td>
            </tr>
            </tbody>
        </table>
    <script>
        this.top = this.parent ? this.parent.top : this
        this.level = this.parent.level
        this.mixin({store:d_visual_designer})
    </script>
</vd-block-order_table>