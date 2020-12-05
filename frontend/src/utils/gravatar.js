import md5 from "md5";

export function get_gravatar(email, size = 80) {
  return `https://${mashiro_option.gravatar_url}/${md5(
    email
  )}.jpg?s=${size}&d=mm`;
}
