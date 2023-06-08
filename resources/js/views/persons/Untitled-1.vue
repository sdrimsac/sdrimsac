
      // if(this.has_card && !this.form_payment.card_brand_id) return this.$toast.error('Seleccione una tarjeta');
       
        
        try {
          

            if (response.data.success) {

                   let document_id=0
                if (this.form.document_type_id === "80") {
                    this.number=response.data.data.number
                    document_id=response.data.data.id;
                    this.form_cash_document.sale_note_id = response.data.data.id;
                 } else {
                     document_id=response.data.data.id;
                    this.form_cash_document.document_id = response.data.data.id;
                    this.number=response.data.data.number
                 }
                    this.documentNewId = response.data.data.id;
                    let printA4 = response.data.data.print_a4;
                    let printA5 = response.data.data.print_a5;
                    let printTicket = response.data.data.print_ticket;
                    let printerName = response.data.data.printer
                    this.cleanLocalStoragePayment();
                    this.$eventHub.$emit("saleSuccess");

                //
                if (this.orden) {
                    const response2 = await this.$http.post("pos/orden_payment", {
                    id: this.orden,
                    customer_id: this.customer.id,
                    document: {
                        isNoteSale: this.form.document_type_id === "80",
                        id: this.documentNewId,
                    },
                    });
                } else {
                }
                  if (this.form.document_type_id === "80") {
                     const response = await this.$http.get(`/restaurant/ordens/payment/80/${this.form_cash_document.sale_note_id}/${this.idOrden}`);
                  } else {

                      const response = await this.$http.get(`/restaurant/ordens/payment/01/${this.form_cash_document.document_id}/${this.idOrden}`);
                 }

                } else {
                this.$toast.error(response.data.message);
                }
                this.clickSendWhatsapp(this.form.document_type_id,this.documentNewId,this.number)
                this.$emit("limpiarForm");
                this.loading_submit = false;


        } catch (error) {

            if (error.response.status === 422) {
            this.errors = error.response.data;
            } else {
            this.$toast.error(error.response.data.message);
            }
            this.loading_submit = false;
        }
        this.back();