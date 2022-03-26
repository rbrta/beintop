export default function ({ store, redirect }) {
  if(store.state.auth.user.usertype === 'manager') {
    return redirect('/manager')
  } else if (store.state.auth.user.usertype !== 'user') {
    return redirect('/')
  }
}
