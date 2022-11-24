import { NotNullPipe } from './not-null.pipe';

describe('NotNullPipe', () => {
  it('create an instance', () => {
    const pipe = new NotNullPipe();
    expect(pipe).toBeTruthy();
  });
});
