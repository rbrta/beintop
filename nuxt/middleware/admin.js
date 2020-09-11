export default function ({ store, redirect }) {
  if (!store.state.auth.loggedIn || store.state.auth.user.usertype !== 'admin') {
    return redirect('/login')
  }
}
