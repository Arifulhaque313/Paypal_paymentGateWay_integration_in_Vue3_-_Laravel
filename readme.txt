# First after clicking the payment button then it hits a route and pass the order id
	
	<Link :href="route('order.payment', {id: orders[0].id})" > 
		<button class="right-0 px-2 py-2 bg-green-500 text-white"> Pay Now </button>
	</Link>


# After that From the controllers Find the order id add pass the data in the payment page

	public function paymentOrder($id){
       		return Inertia::render('Frontend/Payment', ['order' =>Order::find($id)]);
   	}
   	
# Now In the Payment.vue
Get the product price and shipping cost after that calculate them 
after that using this script {


	<template>
	<AppLayout>
		<Head>
			<Title>Payment</Title>
		</Head>
		<div class="max-w-7xl mx-auto px-4 sm:px-6 flex justify-center">
			<div class="xs-6 col-sm-4 col-md-4 col-lg-4 col py-10">
				<!-- Paypal Script -->
				<div ref="paypal"></div>
				<!-- Paypal Scripts -->
			</div>
		</div>
	</AppLayout>
</template>

<script>
import AppLayout from "../../Layouts/FrontEnd/AppLayout.vue"
import {Head} from "@inertiajs/inertia-vue3"
import {Inertia} from "@inertiajs/inertia"
export default {
	name: "subject",
	components: {
		AppLayout,
		Head,
	},
	props: {
		order: Object,
	},
	mounted() {
		const order_id = this.order.id
		let total_amount = (parseFloat(this.order.shipping_cost) + this.order.amount).toFixed(2)
		// Paypal Script Start
		const script = document.createElement("script")

		console.log(process.env.PAYPAL_CLIENT_ID)

		script.src = "https://www.paypal.com/sdk/js?client-id=AUBXU9uGRopNydsPANuZKcP0_faZ2uD8B7cco5A3Yt5j7KEYidQDgdZWErMZdGSIw680hijSlZvhSabg"
		script.addEventListener("load", () => {
			window.paypal
				.Buttons({
					createOrder: function (data, actions) {
						// This function sets up the details of the transaction, including the amount and line item details.
						return actions.order.create({
							purchase_units: [
								{
									amount: {
										value: total_amount,
									},
								},
							],
						})
					},
					onApprove: function (data, actions) {
						// This function captures the funds from the transaction.
						return actions.order.capture().then(function (details) {
							// alert("Transaction completed by " + details.payer.name.given_name)
							const confirmation = Inertia.post(route("order.payment.confirm"), {order_id: order_id, payment: details})
						})
					},
				})
				.render(this.$refs.paypal)
		})
		document.body.appendChild(script)

		// Paypal Script End
	},
}
</script>

<style scoped></style>



}
