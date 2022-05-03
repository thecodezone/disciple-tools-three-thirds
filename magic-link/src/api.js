import magicLinkRequest from "./magicLinkRequest";

export const searchMeetings = async (params) => {
  return await magicLinkRequest('search_meetings', params)
}

export const getMeeting = async (id) => {
  return await magicLinkRequest('meeting', {
    'meeting_id': id
  })
}

export const getMeetings = async (params) => {
  return await magicLinkRequest('meetings', params)
}

export const login = async (data) => {
  return await magicLinkRequest('login', data,'POST')
}

export const logout = async (data) => {
  return await magicLinkRequest('logout', data,'POST')
}

export const createAccount = async (data) => {
  return await magicLinkRequest('register', data,'POST')
}

export const getGroups = async (data) => {
  return await magicLinkRequest('groups', data,'GET')
}

export const saveMeeting = async (data) => {
  return await magicLinkRequest('meeting', data,'PUT')
}
